<?php

namespace Totalcan\DocumancerBundle\Model;

class Wizard
{
    static $step;

    static public function getStep($session)
    {
        if($session->get('step') == 0) {
            $session->set('step', '1');
        } else {
            $i = 1;

            if($session->get('templateId')>0) {
                $i++;
            }

            if($session->get('designId')>0) {
                $i++;
            }

            if($session->get('clientId')>0) {
                $i++;
            }

            $session->set('step', $i);
        }

        $session->getFlashBag()->add(
            'notice',
            'Step '.$session->get('step')
        );

        return $session->get('step');
    }
}