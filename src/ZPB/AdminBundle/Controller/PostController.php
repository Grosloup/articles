<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 18/10/2014
 * Time: 15:48
 */
 /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/

namespace ZPB\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ZPB\AdminBundle\Entity\Post;
use ZPB\AdminBundle\Form\Type\PostType;
use ZPB\AdminBundle\Form\Type\UpdatePostType;

class PostController extends Controller
{
    public function createAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);
        if($form->isValid()){
            $catId = $form->get('category')->getData();
            if($catId){
                $category = $this->getDoctrine()->getRepository('ZPBAdminBundle:PostCategory')->find($catId);
                if($category){
                    $post->setCategory($category);
                }
            }
            $tags = $form->get('tags')->getData();
            if(count($tags)){
                foreach($tags as $tagId){
                    $tag = $this->getDoctrine()->getRepository('ZPBAdminBundle:PostTag')->find($tagId);
                    $post->addTag($tag);
                }
            }
            $targets = $form->get('targets')->getData();
            if(count($targets)){
                $post->setTargets($targets);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirect($this->generateUrl('zpb_admin_index'));
        }

        return $this->render('ZPBAdminBundle:Post:create.html.twig',
            [
                'categories'=>$this->getCategories(),
                'tags'=>$this->getTags(),
                'targets'=>$this->container->getParameter('zpb.post_targets')
            ]
        );
    }

    public function updateAction($id, Request $request)
    {
        $post = $this->getDoctrine()->getRepository('ZPBAdminBundle:Post')->find($id);
        if(!$post){
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new UpdatePostType(), $post);
        $form->handleRequest($request);
        if($form->isValid()){
            $catId = $form->get('category')->getData();
            $oldCat = $post->getCategory();
            if($catId && $oldCat != null){
                if($catId != $oldCat->getId()){
                    $newCat = $this->getDoctrine()->getRepository('ZPBAdminBundle:PostCategory')->find($catId);
                    if($newCat){
                        $post->setCategory($newCat);
                    }
                }
            }

            $tags = $form->get('tags')->getData();
            if(count($tags)){
                $oldTags = $post->getTags();
                foreach($oldTags as $oldTag){
                    if(!in_array($oldTag->getId(), $tags)){
                        $post->removeTag($oldTag);
                    } else {
                        array_splice($tags, array_search($oldTag->getId(), $tags), 1);
                    }
                }
                foreach($tags as $tagId){
                    $tag = $this->getDoctrine()->getRepository('ZPBAdminBundle:PostTag')->find($tagId);
                    if($tag){
                        $post->addTag($tag);
                    }
                }

            }
            $post->setTargets($form->get('targets')->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirect($this->generateUrl('zpb_admin_index'));
        }
        return $this->render('ZPBAdminBundle:Post:update.html.twig',
            [
                'post'=>$post,
                'categories'=>$this->getCategories(),
                'tags'=>$this->getTags(),
                'targets'=>$this->container->getParameter('zpb.post_targets')
            ]
        );
    }

    private function getCategories()
    {
        $categories = $this->getDoctrine()->getRepository("ZPBAdminBundle:PostCategory")->findBy([], ["name"=>"ASC"]);
        return $categories;
        /*return [
            ["id"=>1,"name"=>"cat 1","slug"=>"cat-1"],
            ["id"=>2,"name"=>"cat 2","slug"=>"cat-2"],
            ["id"=>3,"name"=>"cat 3","slug"=>"cat-3"],
            ["id"=>4,"name"=>"cat 4","slug"=>"cat-4"],
        ];*/
    }

    private function getTags()
    {
        $tags = $this->getDoctrine()->getRepository('ZPBAdminBundle:PostTag')->findBy([], ["name"=>"ASC"]);
        return $tags;
        /*return [
            ["id"=>1,"name"=>"tag 1","slug"=>"tag-1"],
            ["id"=>2,"name"=>"tag 2","slug"=>"tag-2"],
            ["id"=>3,"name"=>"tag 3","slug"=>"tag-3"],
            ["id"=>4,"name"=>"tag 4","slug"=>"tag-4"],
        ];*/
    }

}
