<?php

namespace App\Client;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

class StripeClient
{
  private $config;
  private $em;
  private $logger;

  
  public function __construct($secretKey, array $config, EntityManagerInterface $em, LoggerInterface $logger)
  {
    Stripe::setApiKey($secretKey);
    $this->config = $config;
    $this->em = $em;
    $this->logger = $logger;
  }

  /**
   * @param User $user
   * @param $token
   * @throws Base
   */
  public function createPremiumCharge(User $user, $token)
  {
  
      $charge = Charge::create([
        'amount' => 2000,
        'currency' => 'EUR',
        'source' => $token,
        'receipt_email' => $user->getEmail(),
      ]);
 ;
    $user->setChargeId($charge->id);
    $user->setPremium($charge->paid);
    $this->em->persist($user);
    $this->em->flush();
  }
}
