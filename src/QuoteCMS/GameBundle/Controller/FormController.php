<?php

namespace QuoteCMS\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuoteCMS\GameBundle\Form\CategoryType;
use QuoteCMS\GameBundle\Form\GameType;
use QuoteCMS\GameBundle\Entity\Category;
use QuoteCMS\GameBundle\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
//use Tree\Fixture\Closure\Category;


class FormController extends Controller
{
    public function GameFormAction(Request $request)
    {
        $game = new Game();
        $form = $this->get('form.factory')->create(new GameType(), $game);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre jeu à bien été enregistré, merci');
            return $this->redirect($this->generateUrl('quote_cms_moderator_index'));
        }

        return $this->render('QuoteCMSGameBundle:Form:Game.html.twig', array(
            'form' => $form->createView()));
    }

    public function CategoryFormAction(Request $request)
    {
        $category = new Category();
        $form = $this->get('form.factory')->create(new CategoryType(), $category);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre catégorie à bien été enregistrée, merci');
            return $this->redirect($this->generateUrl('quote_cms_game_new'));
        }

        return $this->render('QuoteCMSGameBundle:Form:Category.html.twig', array(
            'form' => $form->createView()));
    }
}
