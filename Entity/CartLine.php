<?php
/**
 * Created by PhpStorm.
 * User: manel
 * Date: 26/01/15
 * Time: 20:56
 */

namespace Cupon\ShoppingCartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Cupon\ShoppingCartBundle\Entity\CartLineRepository")
 */
class CartLine {

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   */
  protected $user;
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Cupon\OfertaBundle\Entity\Oferta")
   */
  protected $offer;
  /**
   * @ORM\Column(type="integer")
   * @Assert\Range(min = 1)
   */
  protected $quantity;

  /**
   * @return mixed
   */
  public function getOffer() {
    return $this->offer;
  }

  /**
   * @param mixed $offer
   */
  public function setOffer(\Cupon\OfertaBundle\Entity\Oferta $offer) {
    $this->offer = $offer;
  }

  /**
   * @return mixed
   */
  public function getQuantity() {
    return $this->quantity;
  }

  /**
   * @param mixed $quantity
   */
  public function setQuantity($quantity) {
    $this->quantity = $quantity;
  }

  /**
   * @return mixed
   */
  public function getUser() {
    return $this->user;
  }

  /**
   * @param mixed $user
   */
  public function setUser($user) {
    $this->user = $user;
  }


  public function getItem() {
    return $this->getOffer();
  }

} 