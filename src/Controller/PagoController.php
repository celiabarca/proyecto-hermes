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
    $phoneNumber = $request->query->get('reset') ? new PhoneNumber() : $user->getPhoneNumber();
    $twilioNumber = $this->getParameter('twilio_number');

    if ($request->isXmlHttpRequest()) {
      return new JsonResponse([
        'verified' => $phoneNumber->isVerified(),
      ]);
    }

    if ($user->isPremium()) {
      return $this->redirectToRoute('index');
    }

    if ($phoneNumber->getVerificationCode()) {
      return $this->render('pago/verificar.html.twig', [
        'verification_code' => $phoneNumber->getVerificationCode(),
        'redirect' => $this->get('session')->get('premium_redirect'),
        'twilio_number' => $twilioNumber,
      ]);
    }

    $form = $this->createFormBuilder($phoneNumber)
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

      if ($form->isValid()) {
        $phoneNumber->setVerificationCode();
        $this->getUser()->setPhoneNumber($phoneNumber);
        $this->getDoctrine()->getManager()->flush();

        $this->get('twilio.client')->calls->create(
          $phoneNumber->getNumber(),
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

    if ($user->isPremium()) {
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

          $this->get('App\Client\Stripe')->createPremiumCharge($this->getUser(), $form->get('token')->getData());
          $redirect = $this->get('session')->get('premium_redirect');
          $redirect = $this->generateUrl('premium_payment');
          return $this->redirectToRoute("index");
      }
    }

    return $this->render('pago/pago.html.twig', [
      'form' => $form->createView(),
      'stripe_public_key' => $this->getParameter('stripe_public_key'),
    ]);
  }
}
