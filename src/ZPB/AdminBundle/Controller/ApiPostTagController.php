<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/10/2014
 * Time: 10:17
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
use ZPB\AdminBundle\Entity\PostTag;

class ApiPostTagController extends Controller
{
    public function createAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException();
        }

        $datas = json_decode($request->getContent(),true);
        $tag = new PostTag();
        $this->bindDatas($tag, $datas);
        $validator = $this->get('validator');
        $errors = $validator->validate($tag);
        if(count($errors)>0){
            $response = ["error"=>true, "tag"=>["id"=>$datas["id"], "name"=>$datas["name"], "slug"=>$datas["slug"]], "message"=>$errors];
        }else{
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            $response = ["error"=>false, "tag"=>["id"=>$tag->getId(), "name"=>$tag->getName(), "slug"=>$tag->getSlug()], "message"=>"Mot-clé enregistré."];
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
