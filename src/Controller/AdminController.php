<?php
// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminController extends AbstractController
{

    /**
     * @Route("/post", name="show_post")
     */

    public function showPost()
    {
        $repository = $this->getDoctrine()->getRepository(Orders::class);

        $posts = $repository->findAll();

//        echo '<pre>';
//        print_r($posts);
//        echo '</pre>';
//        exit();

        return $this->render("admin/index.html.twig", ['itemsPost' => $posts]);
    }


    /**
     * @Route("/post/view/{id}", name="view_post_route")
     */
        public function viewPostAction($id){
            $repository = $this->getDoctrine()->getRepository(Orders::class);

            $post = $repository->find($id);

//                    echo '<pre>';
//                    print_r($post);
//                    echo '</pre>';
//                    exit();
            return $this->render("admin/view.html.twig", ['post' => $post]);

        }



     /**
      * @Route("/post/update/{id}", name="upgrade_post_route")
      */
        public function updatePost(Request $request, $id){
//            echo $id;
//            exit();

            $post = $this->getDoctrine()->getRepository(Orders::class)->find($id);

                $post->setPlacedby($post->getPlacedby());
                $post->setDetails($post->getDetails());
                $post->setLocation($post->getLocation());
                $post->setTopay($post->getTopay());
                    $form = $this->createFormBuilder($post)
                        ->add('placedby', TextType::Class, array('attr' => array('class' => 'form-control')))
                        ->add('details', TextareaType::Class, array('attr' => array('class' => 'form-control')))
                        ->add('location', TextType::Class, array('attr' => array('class' => 'form-control')))
                        ->add('topay', TextType::Class, array('attr' => array('class' => 'form-control')))
                        ->add('save', SubmitType::Class, array('label' => 'Edit/Update Order', 'attr' =>
                            array('class' => 'btn btn-primary', 'style' => 'margin-top : 15px')))
                            ->getForm();
                    $form->handleRequest($request);
                        if($form->isSubmitted() && $form->isValid()){
                            $placedby = $form['placedby']->getData();
                            $details = $form['details']->getData();
                            $location = $form['location']->getData();
                            $topay = $form['topay']->getData();

                            $em = $this ->getDoctrine()->getManager();
                            $post =$em->getRepository(Orders::class)->find($id);

                            $post->setPlacedby($placedby);
                            $post->setDetails($details);
                            $post->setLocation($location);
                            $post->setTopay($topay);

                            $em ->flush();
                            $this->addFlash('message', 'Operation Successful!!!');
                            return $this->redirectToRoute('show_post');

                        }

//                echo '<pre>';
//                print_r($post);
//                echo '</pre>';
//                exit();

            return $this->render("admin/update.html.twig", [
                        'form' => $form->createView()
            ]);
        }




        /**
         * @Route("/post/delete/{id}" ,  name="delete_post")
         */
        public function deletePost($id){
//            echo $id;
//            exit();

            $em= $this->getDoctrine()->getManager();
            $post = $em->getRepository(Orders::class)->find($id);
            $em->remove($post);
            $em ->flush();
                            $this->addFlash('message', 'Delete Successful!!!');
                            return $this->redirectToRoute('show_post');

        }


}








