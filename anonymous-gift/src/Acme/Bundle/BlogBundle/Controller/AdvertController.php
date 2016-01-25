<?php

namespace Acme\Bundle\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Acme\Bundle\BlogBundle\Entity\User;
use Acme\Bundle\BlogBundle\Form\UserType;

class AdvertController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
    $content = $this->get('templating')->render('AcmeBlogBundle:Advert:index.html.twig');
    return new Response($content);
	}

public function connectAction(Request $request)
    {
    $user = new User();
    $formBuilder = $this->get('form.factory')->createBuilder('form', $user);

    $formBuilder
      ->add('email',      'text')
      ->add('password',     'password')
      ->add('connect', 'submit')
    ;

    $form = $formBuilder->getForm();


    if ($form->handleRequest($request)->isValid()) 
    {	
      $repository = $this
	  ->getDoctrine()
	  ->getManager()
	  ->getRepository('AcmeBlogBundle:User')
	  ;

	  $listUsers = $repository->findAll();
	  $isDefined = false;
	  foreach ($listUsers as $userBase)
	   {
	   		if ($userBase -> getEmail() === $user -> getEmail()  && $userBase -> getPassword() === $user -> getPassword()){
	   		$request->getSession()->getFlashBag()->add('notice', 'Bienvenue.');
	   		return $this->redirect($this->generateUrl('anonymous_test'));	
	   		}
		}

      $request->getSession()->getFlashBag()->add('notice', 'Utilisateur non reconnu.');
  		return $this->redirect($this->generateUrl('anonymous_signin'));

	}
	 return $this->render('AcmeBlogBundle:Advert:connect.html.twig', array(
      'form' => $form->createView(),
    ));
  }

	public function signinAction(Request $request)
    {
    $user = new User();
    $form = $this->get('form.factory')->create(new UserType(), $user);

    if ($form->handleRequest($request)->isValid()) 
    {	
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistrée.');

      return $this->redirect($this->generateUrl('anonymous_home'));

	}
	 return $this->render('AcmeBlogBundle:Advert:signin.html.twig', array(
      'form' => $form->createView(),
    ));
  }


}

