<?php

namespace App\Controller;

use App\Event\StripeEvent;
use Stripe\Error\SignatureVerification;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class StripeController extends Controller
{
  /**
   * @param Request $request
   * @return Response
   * @throws BadRequestHttpException
   */
  public function webhookAction(Request $request)
  {
    $header = 'Stripe-Signature';
    $signature = $request->headers->get($header);

    if (is_null($signature)) {
      throw new BadRequestHttpException(sprintf('Missing header %s', $header));
    }

    try {
      $event = new StripeEvent(Webhook::constructEvent($request->getContent(), $signature, $this->getParameter('stripe_signing_secret')));
    } catch (\UnexpectedValueException $e) {
      throw new BadRequestHttpException('Invalid Stripe payload');
    } catch (SignatureVerification $e) {
      throw new BadRequestHttpException('Invalid Stripe signature');
    }

    $this->get('event_dispatcher')->dispatch($event->getName(), $event);

    return new Response();
  }
}
