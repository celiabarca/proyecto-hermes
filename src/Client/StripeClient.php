<?php

namespace App\Client;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;
use App\Entity\Project;



class StripeClient
{
  private $config;
  private $em;
  private $logger;
  private $price;
  

  
  public function __construct($secretKey, array $config, EntityManagerInterface $em, LoggerInterface $logger)
  {
    Stripe::setApiKey($secretKey);
    $this->config = $config;
    $this->em = $em;
    $this->logger = $logger;
    $this->price = 2000;
  }

  /**
   * @param User $user
   * @param $token
   * @throws Base
   */
  public function CrearCargo(User $user, $token)
  {
      
      $charge = Charge::create([
        'amount' => $this->price,
        'currency' => 'EUR',
        'source' => $token,
        'receipt_email' => $user->getEmail()
      ]);
      
    
  }
  public function DescacarUsuario(User $user, $token)
  {
      $this->CrearCargo($user, $token);
      $user->setDestacado(true);
      $this->em->persist($user);
      $this->em->flush();
  }
  
        public function DonarProyecto(User $user, $token, $cantidad)
        {
          $this->setPrice($cantidad);
          $this->CrearCargo($user, $token);

      }
  
    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }


}