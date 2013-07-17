<?php

/*
 * This file is part of the FOSBravoregBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Totalcan\BravoregBundle\Security\EntryPoint;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * BravoregAuthenticationEntryPoint starts an authentication via Bravoreg.
 *
 * @author Thomas Adam <thomas.adam@tebot.de>
 */
class BravoregAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    protected $Bravoreg;
    protected $options;
    protected $permissions;

    /**
     * Constructor
     *
     * @param BaseBravoreg $Bravoreg
     * @param array    $options
     */
    public function __construct(\BaseBravoreg $Bravoreg, array $options = array(), array $permissions = array())
    {
        $this->Bravoreg = $Bravoreg;
        $this->permissions = $permissions;
        $this->options = new ParameterBag($options);
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {

        $redirect_to_Bravoreg = $this->options->get('redirect_to_Bravoreg_login');
        if ($redirect_to_Bravoreg == false) {
            $loginPath = $this->options->get('login_path');
            return new RedirectResponse($loginPath);
        }

        $redirect_uri = $request->getUriForPath($this->options->get('check_path', ''));
        if ($this->options->get('server_url') && $this->options->get('app_url')) {
            $redirect_uri = str_replace($this->options->get('server_url'), $this->options->get('app_url'), $redirect_uri);
        }
        
        $loginUrl = $this->Bravoreg->getLoginUrl(
           array(
                'display' => $this->options->get('display', 'page'),
                'scope' => implode(',', $this->permissions),
                'redirect_uri' => $redirect_uri,
        ));
        
        if ($this->options->get('server_url') && $this->options->get('app_url')){
            return new Response('<html><head></head><body><script>top.location.href="'.$loginUrl.'";</script></body></html>');
        }
        
        return new RedirectResponse($loginUrl);
    }
}