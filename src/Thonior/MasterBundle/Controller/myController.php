<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class myController extends Controller
{

    public function isAuthor($entity){
        if($this->getUser() != 'anon.')
            return $entity->getAuthor()->getId() == $this->getUser()->getId();
        else
            return false;
    }
    
    public function getUser(){
        return $this->get('security.context')->getToken()->getUser();
    }
    
    public function getSession($var, Request $request){
        $session = $request->getSession();
        $value = $session->get($var);
        return $value;
    }
    
    public function template(Request $request,$vars = array()){
        $session = $request->getSession();        
        $universes = $this->getDoctrine()->getRepository('ThoniorMasterBundle:Universe')->findAll();
	
	if($session->has('universe')){
	    $currentUni = $session->get('universe');
	}
	else{
	    $currentUni = $universes[0]->getName();
	    $session->set('universe', $currentUni);
	}
        $header = array(
            'currentUni' => $currentUni,
            'universes' => $universes
        );
        $view = array_merge($header,$vars);
        return $view;
    }
    
}
