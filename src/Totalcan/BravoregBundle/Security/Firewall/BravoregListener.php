<?php

namespace Totalcan\BravoregBundle\Security\Firewall;

use Totalcan\BravoregBundle\Security\Authentication\Token\BravoregUserToken;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;

class BravoregListener extends AbstractAuthenticationListener
{
    protected function attemptAuthentication(Request $request)
    {
        $accessToken = $request->get('token');

        return $this->authenticationManager->authenticate(new BravoregUserToken($this->providerKey, '', array(), $accessToken));
    }
}
