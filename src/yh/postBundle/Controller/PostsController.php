<?php

namespace yh\postBundle\Controller;

use yh\postBundle\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use yh\commentsBundle\Entity\Comments;

/**
 * Post controller.
 *
 */
class PostsController extends Controller {

    /**
     * Lists all post entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('yhpostBundle:Posts')
                ->findBy(array(), array("id" => 'DESC'), 3, null);

        return $this->render('yhblogBundle:Pages:articles/listing.html.twig', array(
                    'posts' => $posts,
        ));
    }

    /**
     * Creates a new post entity.
     *
     */
    public function newAction(Request $request) {
        if (!$this->getUser()) {
            $this->addFlash('alert', 'You must be identified to access this section');
            return $this->redirectToRoute('yhblog_homepage');
        } else {
            $post = new Posts();
            $form = $this->createForm('yh\postBundle\Form\PostsType', $post);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $post->setUser($this->getUser());
                $post->setAuthor($this->getUser()->getusername());
                // /* Obliger de faire ca sinon la date est déja au format string et ca ne fonctionne pas 
                $postedAt = new \DateTime("now");
                $post->setCreatedAt($postedAt);
                // */
                $em->persist($post);
                $em->flush($post);

                return $this->redirectToRoute('posts_show', array('id' => $post->getId()));
            }

            return $this->render('yhblogBundle:Pages:articles/new.html.twig', array(
                        'post' => $post,
                        'form' => $form->createView()
            ));
        }
    }

    /**
     * Finds and displays a post entity.
     *
     */
    public function showAction(Posts $post, Request $request) {
        $allowed = false;
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            if ($post->getAuthor() == $this->getUser()->getusername()) {
                $allowed = true;
            }
        }
        $deleteForm = $this->createDeleteForm($post);
        $user = false;
        if ($this->getUser()) {
            $user = true;
        }
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('yhcommentsBundle:Comments')
                ->findBy(array("postId" => $post->getId()), array("id" => 'DESC'));
        $comment = new Comments();
        $form = $this->createForm('yh\commentsBundle\Form\CommentsType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $comment->setUserId($this->getUser());
            $comment->setPostId($post->getId());
            $comment->setUsername($this->getUser()->getusername());
            $postedAt = new \DateTime("now");
            $comment->setCreatedAt($postedAt);

            $em->persist($comment);
            $em->flush($comment);

            $this->addFlash('success', 'Votre commenaire a été ajouté');
            return $this->redirectToRoute('posts_show', array('id' => $post->getId()));
        }

        if ($post->getExtension()) {
            $imageUrl = $post->getUploadDir() . '/' . $post->getImage();
        } else {
            $imageUrl = "https://dummyimage.com/1000x500/000/fff.jpg&text=404+not+found+--+Pas+d\'image";
        }

        return $this->render('yhblogBundle:Pages:articles/post.html.twig', array(
                    'post' => $post,
                    'delete_form' => $deleteForm->createView(),
                    'user' => $user,
                    'comments' => $comments,
                    'comment' => $comment,
                    'form' => $form->createView(),
                    'imageURL' => $imageUrl,
                    'allowed' => $allowed,
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     */
    public function editAction(Request $request, Posts $post) {
        // seul l'auteur de l'article a le droit de le modifier 
        // mais les admins aussi
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            if ($post->getAuthor() == $this->getUser()->getusername()) {
                $deleteForm = $this->createDeleteForm($post);
                $editForm = $this->createForm('yh\postBundle\Form\PostsType', $post);
                $editForm->handleRequest($request);

                if ($editForm->isSubmitted() && $editForm->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('posts_show', array('id' => $post->getId()));
                }

                $postHTML = $post->getContenthtml();
                $postURL = $request->attributes->get('_route') . '/../show';

                return $this->render('yhblogBundle:Pages:articles/edit.html.twig', array(
                            'post' => $post,
                            'edit_form' => $editForm->createView(),
                            'delete_form' => $deleteForm->createView(),
                            'postHTML' => $postHTML,
                            'postURL' => $postURL,
                ));
            } else {
                $this->addFlash('alert', 'Vous ne pouvez modifier que vos articles');
                return $this->redirectToRoute('yhblog_homepage');
            }
        } else {
            // tentative de vol d'article
            $this->addFlash('error', 'Que fais-tu là ??? Petit joueur !');
            return $this->redirectToRoute('yhblog_homepage');
        }
    }

    /**
     * Deletes a post entity.
     *
     */
    public function deleteAction(Request $request, Posts $post) {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush($post);
        }

        return $this->redirectToRoute('posts_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Posts $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Posts $post) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('posts_delete', array('id' => $post->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
