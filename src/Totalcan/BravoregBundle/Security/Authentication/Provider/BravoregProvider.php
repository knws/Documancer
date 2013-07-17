<?php

/*
 * This file is part of the FOSBravoregBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Totalcan\BravoregBundle\Security\Authentication\Provider;

use Totalcan\BravoregBundle\Security\User\UserManagerInterface;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;

use Totalcan\BravoregBundle\Security\Authentication\Token\BravoregUserToken;

class BravoregProvider implements AuthenticationProviderInterface
{
    /**
     * @var \BaseBravoreg
     */
    protected $Bravoreg;
    protected $providerKey;
    protected $userProvider;
    protected $userChecker;
    protected $createIfNotExists;

    public function __construct($providerKey, \BaseBravoreg $Bravoreg, UserProviderInterface $userProvider = null, UserCheckerInterface $userChecker = null, $createIfNotExists = false)
    {
        if (null !== $userProvider && null === $userChecker) {
            throw new \InvalidArgumentException('$userChecker cannot be null, if $userProvider is not null.');
        }

        if ($createIfNotExists && !$userProvider instanceof UserManagerInterface) {
            throw new \InvalidArgumentException('The $userProvider must implement UserManagerInterface if $createIfNotExists is true.');
        }

        $this->providerKey = $providerKey;
        $this->Bravoreg = $Bravoreg;
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
        $this->createIfNotExists = $createIfNotExists;
    }

    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }

        $user = $token->getUser();
        if ($user instanceof UserInterface) {
            $this->userChecker->checkPostAuth($user);

            $newToken = new BravoregUserToken($this->providerKey, $user, $user->getRoles(), $token->getAccessToken());
            $newToken->setAttributes($token->getAttributes());

            return $newToken;
        }

        if (!is_null($token->getAccessToken())) {
              $this->Bravoreg->setAccessToken($token->getAccessToken());
        }

        if ($uid = $this->Bravoreg->getUser()) {
            $newToken = $this->createAuthenticatedToken($uid,$token->getAccessToken());
            $newToken->setAttributes($token->getAttributes());

            return $newToken;
        }

        throw new AuthenticationException('The Bravoreg user could not be retrieved from the session.');
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof BravoregUserToken && $this->providerKey === $token->getProviderKey();
    }

    protected function createAuthenticatedToken($uid, $accessToken = null)
    {
        if (null === $this->userProvider) {
            return new BravoregUserToken($this->providerKey, $uid, array(), $accessToken);
        }

        try {
            $user = $this->userProvider->loadUserByUsername($uid);
            if ($user instanceof UserInterface) {
                $this->userChecker->checkPostAuth($user);
            }
        } catch (UsernameNotFoundException $ex) {
            if (!$this->createIfNotExists) {
                throw $ex;
            }

            $user = $this->userProvider->createUserFromUid($uid);
        }

        if (!$user instanceof UserInterface) {
            throw new AuthenticationException('User provider did not return an implementation of user interface.');
        }

        return new BravoregUserToken($this->providerKey, $user, $user->getRoles(), $accessToken);
    }

}
