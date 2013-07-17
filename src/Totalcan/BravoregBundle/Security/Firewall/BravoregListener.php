<?php

/*
 * This file is part of the FOSBravoregBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Totalcan\BravoregBundle\Security\Firewall;

use Totalcan\BravoregBundle\Security\Authentication\Token\BravoregUserToken;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bravoreg authentication listener.
 */
class BravoregListener extends AbstractAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
        $accessToken = $request->get('access_token');

        return $this->authenticationManager->authenticate(new BravoregUserToken($this->providerKey, '', array(), $accessToken));
    }
}
