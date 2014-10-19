<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 18/10/2014
 * Time: 22:27
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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ZPB\AdminBundle\Entity\PostCategory;

class ApiPostCategoryController extends Controller
{
    public function createAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException();
        }
        $validator = $this->get('validator');

        $datas = json_decode($request->getContent(),true);
        $category = new PostCategory();

        $this->bindDatas($category, $datas);
        $errors = $validator->validate($category);
        if(count($errors)>0){
            $response = ["error"=>true, "cat"=>["id"=>$datas["id"], "name"=>$datas["name"], "slug"=>$datas["slug"]], "message"=>$errors];
        }else{
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $response = ["error"=>false, "cat"=>["id"=>$category->getId(), "name"=>$category->getName(), "slug"=>$category->getSlug()], "message"=>"Catégorie enregistrée."];
        }

        return new JsonResponse($response);
    }

    public function readAction($id, Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException();
        }
    }

    public function allAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException();
        }
    }

    public function deleteAction($id, Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException();
        }
    }

    public function updateAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException();
        }

        $datas = json_decode($request->getContent(),true);
        $response = ["error"=>false, "cat"=>["id"=>$datas["id"], "name"=>$datas["name"], "slug"=>"updatedSlug"]];
        return new JsonResponse($response);
    }

    private function bindDatas($entity, $datas)
    {
        foreach($datas as $k=>$v){
            $method = "set" . ucfirst($k);
            if(method_exists($entity, $method)){
                $entity->$method($v);
            }
        }
    }
}
