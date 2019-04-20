<?php
// src/Controller/Driver.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class Driver extends AbstractController
{

    /**
     * @Route("/driver", name="show_post_driver")
     */

    public function showPost()
    {
        $repository = $this->getDoctrine()->getRepository(Orders::class);

        $posts = $repository->findAll();

//        echo '<pre>';
//        print_r($posts);
//        echo '</pre>';
//        exit();

        return $this->render("driver/driver.html.twig", ['itemsPost' => $posts]);
    }


    /**
     * @Route("/driver/view/{id}", name="view_post_driver")
     */
    public function viewPostAction($id){
        $repository = $this->getDoctrine()->getRepository(Orders::class);

        $post = $repository->find($id);

//                    echo '<pre>';
//                    print_r($post);
//                    echo '</pre>';
//                    exit();
        return $this->render("driver/driverView.html.twig", ['post' => $post]);

    }

}