<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Project;

/**
 * @Route("/premium")
 */
class PagoController extends Controller
{


  /**
   * @param Request $request
   * @return Response
   */
  public function verifyAction(Request $request)
  {
    /** @var User $user */
    $user= $this->getUser();
    $phoneNumber = $request->query->get('reset') ? ' ' : $user->getTelefono();
    $twilioNumber = $this->getParameter('twilio_number');

    if ($request->isXmlHttpRequest()) {
      return new JsonResponse([
        'verified' => true,
      ]);
    }

    if ($user->getDestacado()) {
      return $this->redirectToRoute('index');
    }

    

    $form = $this->createFormBuilder()
      ->add('number', TextType::class, [
        'label' => 'Phone Number',
      ])
      ->add('country', CountryType::class, [
        'preferred_choices' => ['ES'],
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Continue',
      ])
      ->getForm();

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) 
          {
        $this->getUser()->setPhoneNumber($phoneNumber);
        $this->getDoctrine()->getManager()->flush();

        $this->get('twilio.client')->calls->create
            (
                $user->getTelefono(),
                $twilioNumber,
                ['url' => $this->generateUrl('twilio_voice_verify', [], UrlGeneratorInterface::ABSOLUTE_URL)]
            );
        return $this->redirectToRoute('premium_verify');
        }
    }
    return $this->render('pago/verificar.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @param Request $request
   * @return Response
   */
  public function paymentAction(Request $request)
  {
    /** @var User $user */
    $user = $this->getUser();

    if ($user->getDestacado()) {
      return $this->redirectToRoute('index');
    }

    $form = $this->get('form.factory')
      ->createNamedBuilder('payment-form')
      ->add('token', HiddenType::class, [
        'constraints' => [new NotBlank()],
      ])
      ->add('submit', SubmitType::class)
      ->getForm();

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);

      if ($form->isValid()) {

          $this->get('App\Client\Stripe')->CrearCargo($this->getUser(), $form->get('token')->getData());

          return $this->redirectToRoute("index");
      }
    }
    return $this->render('pago/pago.html.twig', [
      'form' => $form->createView(),
      'stripe_public_key' => $this->getParameter('stripe_public_key'),
    ]);
  }
  
  public function DonarProyecto(Project $proyecto, Request $req)
  {
    $form = $this->get('form.factory')
        ->createNamedBuilder('payment-form')
        ->add('token', HiddenType::class, [
          'constraints' => [new NotBlank()],
        ])
        ->add("cantidad", \Symfony\Component\Form\Extension\Core\Type\NumberType::class)
        ->add('submit', SubmitType::class)
        ->getForm();

    if ($request->isMethod('POST')) 
        {
        $form->handleRequest($request);
        if ($form->isValid()) 
        {
            $precio = $form["precio"];
            $this->get('App\Client\Stripe')->CrearCargo($this->getUser(), $form->get('token')->getData(),$form['precio'],$form['proyect']);
            return $this->redirectToRoute("/proyecto/",["id"=>$proyecto->getId()]);
        }
    }  
    //return $this->render("/proyecto/donar.html.twig",["Proyecto"=>$proyecto], "form"=>$form);
  }
}
