<?php

namespace ZPB\Sites\ZooBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('ZPBAdminBundle:Post')->findBy([], ['updatedAt'=>'DESC']);
        return $this->render('ZPBSitesZooBundle:Index:index.html.twig', ['posts'=>$posts]);
    }

}
