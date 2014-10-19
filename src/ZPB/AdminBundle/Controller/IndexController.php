<?php

namespace ZPB\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $post = $this->getDoctrine()->getRepository('ZPBAdminBundle:Post')->findBy([], ['createdAt'=>'DESC']);
        return $this->render('ZPBAdminBundle:Index:index.html.twig', ['posts'=>$post]);
    }

}
