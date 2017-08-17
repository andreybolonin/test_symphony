<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            "articles" => $articles
        ]);
    }
}
