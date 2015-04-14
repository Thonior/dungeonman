<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class myController extends Controller
{
    /**
     * USER HELPER
     */
    
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
    
    /**
     * PREPARES A VIEW WITH THE HEADER VARIABLES
     */
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
    
    /**
     * DEBUGGING
     */
    
    public function show($var){
        echo "<pre>";var_dump($var);die;
    }
    
    /**
     * TAGGING HELPER FUNCTIONS
     */
    
    public function getTagman(){
        $tagManager = $this->get('fpn_tag.tag_manager');
        return $tagManager;
    }
    
    public function serializeTags($tags){
        $string = '';
        $i = 0;
        foreach($tags as $tag){
            $string .= $tag;
            if( $i < count($tags)){
                $string.= ',';
            }
        }
        return $string;
    }
    
    public function tag($tags,$entity){
        $tagman = $this->getTagman();
        $tagNames = $tagman->splitTagNames($tags);
        $tags = $tagman->loadOrCreateTags($tagNames);
        $entity->setTags(null);
        $tagman->addTags($tags,$entity);
        
        return $tagman;
    }
    
    public function getTags($entity){
        $tagman = $this->getTagman();
        $tagman->loadTagging($entity);
        $tags = $tagman->getTagNames($entity);
        $entity->setTags($tags);
        return $entity;
    }
    
    public function getSerializedTags($entity){
        $tagman = $this->getTagman();
        $tagman->loadTagging($entity);
        $tags = $tagman->getTagNames($entity);
        $tags = $this->serializeTags($tags);
        $entity->setTags($tags);
        return $entity;
    }
}
