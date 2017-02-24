<?php

namespace yh\blogBundle\Controller;

use yh\blogBundle\Entity\users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use yh\postBundle\Entity\Posts;
use yh\commentsBundle\Entity\Comments;

class ApiController extends Controller {

    public function indexAction() {
        return $this->render('yhblogBundle:Default:index.html.twig');
    }

    public function PostsAction(Request $request, $id = null) {
        if (!$id) {
            $em = $this->getDoctrine()->getManager();
            $posts = $em->getRepository('yhpostBundle:Posts')
                    ->findby(array(), array("id" => 'DESC'));
            $data = array();

            foreach ($posts as $post) {
                $temparray["id"] = $post->getId();
                $temparray["author"] = $post->getAuthor();
                $temparray["title"] = $post->getTitle();
                $temparray["summary"] = $post->getSummary();
                $temparray["content"] = $post->getContent();
                $temparray["content_html"] = $post->getContenthtml();
                $temparray["created_at"] = $post->getCreatedAt();
                array_push($data, $temparray);
            }

            /* var_dump($data); */

            return $this->json(array('data' => $data));
        } else {
            // si un id est passé en param
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('yhpostBundle:Posts')
                    ->findBy(array("id" => $id));
            //var_dump($post);
            $post = $post[0];

            $data["id"] = $post->getId();
            $data["author"] = $post->getAuthor();
            $data["title"] = $post->getTitle();
            $data["summary"] = $post->getSummary();
            $data["content"] = $post->getContent();
            $data["content_html"] = $post->getContenthtml();
            $data["created_at"] = $post->getCreatedAt();

            return $this->json(array('data' => $data));
        }
    }

    public function PostsOffsetAction(Request $request, $start, $offset = null) {
        if($offset == null){
            $offset = 3;
        }
        
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('yhpostBundle:Posts')
                ->findBy(array(), array("id" => 'DESC'), $offset, $start);
        $data = array();

        foreach ($posts as $post) {
            $temparray["id"] = $post->getId();
            $temparray["author"] = $post->getAuthor();
            $temparray["title"] = $post->getTitle();
            $temparray["summary"] = $post->getSummary();
            $temparray["content"] = $post->getContent();
            $temparray["content_html"] = $post->getContenthtml();
            $temparray["created_at"] = $post->getCreatedAt();
            array_push($data, $temparray);
        }

        /* var_dump($data); */

        return $this->json(array('data' => $data));
    }

}
