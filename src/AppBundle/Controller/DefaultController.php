<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;

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

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $user = $repository->find($id);
        $em = $this->getDoctrine()->getManager();

        if ($user) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

        }

        return $this->render('default/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
