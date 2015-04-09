<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Hero;
use Thonior\MasterBundle\Form\HeroType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Hero controller.
 *
 * @Route("/search")
 */
class SearchController extends myController
{
    
    /**
     * Lists all Hero entities.
     *
     * @Route("/", name="search")
     * @Method("POST")
     * @Template()
     */
    public function searchAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        $universe = $request->getSession()->get('universe');
        $universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
        
        $string = $this->get('request')->request->get('search');
        $page = ($this->get('request')->request->get('page') ? $this->get('request')->request->get('page') : 0);
        $environment = $this->get('request')->request->get('environment');
        
        if($environment){
            $result = $this->searchStuff($string, $universe, $page, $environment);
        }
        else{
            //movidón
        }
        
        $vars = array (
            'result' => $result
        );
                
        return $this->template($request, $vars);
        
        
    }
    
    private function searchStuff($string, $universe, $page, $environment){
        $repository = $this->getDoctrine()->getRepository("ThoniorMasterBundle:".$environment);
        $qb = $repository->createQueryBuilder('s');
        
        $offset = 10 * $page;
        
        $query = $qb->where('s.universe = :universe')
                ->andWhere(
                    $qb->expr()->like('s.name', ':string')
                    )
                ->setParameter('universe', $universe->getId())
                ->setParameter('string','%'.$string.'%')
                ->orderBy('s.name','DESC')
                ->setFirstResult($offset)
                ->setMaxResults(10)
                ->getQuery();
        
        $stuff = $query->getResult();
        return $stuff;
    }
    
    private function searchItems($string, $universe ,$page = 0){
        $repository = $this->getDoctrine()->getRepository("ThoniorMasterBundle:Item");
        
        $qb = $repository->createQueryBuilder('i');
        
        $query = $qb('i')
                ->where('i.universe = :universe')
                ->setParameter('universe', $universe->getId())
                ->orderBy('i.name','DESC')
                ->setFirstResult(0)
                ->setMaxResults(2);
    }
    
    private function searchRaces($string, $universe ,$page = 0){
        $repository = $this->getDoctrine()->getRepository("ThoniorMasterBundle:Race");
        $qb = $repository->createQueryBuilder('i');
        
        $offset = 10 * $page;
        
        $query = $qb->where('i.universe = :universe')
                ->andWhere(
                    $qb->expr()->like('i.name', ':string')
                    )
                ->setParameter('universe', $universe->getId())
                ->setParameter('string','%'.$string.'%')
                ->orderBy('i.name','DESC')
                ->setFirstResult($offset)
                ->setMaxResults(10)
                ->getQuery();
        
        $races = $query->getResult();
        return $races;
    }
    
    private function searchJobs($string, $universe ,$page = 0){
        $repository = $this->getDoctrine()->getRepository("ThoniorMasterBundle:Job");
        $qb = $repository->createQueryBuilder('j');
        
        $offset = 10 * $page;
        
        $query = $qb->where('j.universe = :universe')
                ->andWhere(
                    $qb->expr()->like('j.name', ':string')
                    )
                ->setParameter('universe', $universe->getId())
                ->setParameter('string','%'.$string.'%')
                ->orderBy('j.name','DESC')
                ->setFirstResult($offset)
                ->setMaxResults(10)
                ->getQuery();
        
        $jobs = $query->getResult();
        return $jobs;
    }
    
    private function searchHeroes($string, $universe ,$page = 0){
        $repository = $this->getDoctrine()->getRepository("ThoniorMasterBundle:Hero");
        $qb = $repository->createQueryBuilder('h');
        
        $offset = 10 * $page;
        
        $query = $qb->where('h.universe = :universe')
                ->andWhere(
                    $qb->expr()->like('h.name', ':string')
                    )
                ->setParameter('universe', $universe->getId())
                ->setParameter('string','%'.$string.'%')
                ->orderBy('h.name','DESC')
                ->setFirstResult($offset)
                ->setMaxResults(10)
                ->getQuery();
        
        $heroes = $query->getResult();
        return $heroes;
    }
    
}