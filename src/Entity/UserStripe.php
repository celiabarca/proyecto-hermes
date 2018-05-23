<?php

namespace App\Entity;

use App\Entity\Traits\HasPremium;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="`userStripe`")
 */
class UserStripe extends User
{
  use HasPremium;


  /**
   * @var string
   *
   * @ORM\Column(name="charge_id", type="string", length=255, nullable=true)
   */
  protected $chargeId;

  public function __construct()
  {
    parent::__construct();

    $this->phoneNumber = new PhoneNumber();
  }

  /**
   * @return string
   */
  public function getFullName()
  {
    return trim(sprintf('%s %s', $this->getFirstName(), $this->getLastName()));
  }

  /**
   * @param string $firstName
   * @return $this
   */
  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;

    return $this;
  }

  /**
   * @return string
   */
  public function getFirstName()
  {
    return $this->firstName;
  }

  /**
   * @param string $lastName
   * @return $this
   */
  public function setLastName($lastName)
  {
    $this->lastName = $lastName;

    return $this;
  }

  /**
   * @return string
   */
  public function getLastName()
  {
    return $this->lastName;
  }

  /**
   * @param string $chargeId
   * @return $this
   */
  public function setChargeId($chargeId)
  {
    $this->chargeId = $chargeId;

    return $this;
  }

  /**
   * @return string
   */
  public function getChargeId()
  {
    return $this->chargeId;
  }
}
