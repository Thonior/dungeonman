<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends myController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
	
        return $this->template($request);
    }
    
    /**
     * @Route("/switchuni/{universe}", name="switchuni")
     */
    public function switchUniverseAction($universe, Request $request){
	$session = $request->getSession();
	
	$session->set('universe',$universe);
	
	return $this->redirect($this->generateUrl('homepage'));
    }
    
    /**
     * @Route("/nopermission", name="nopermission")
     */
    public function noPermissionAction(){
        return $this->render('ThoniorMasterBundle:Default:noPermission.html.twig');
    }
    
}
