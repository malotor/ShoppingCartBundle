<?php

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use Cupon\ShoppingCartBundle\Entity\CartLine;
use malotor\shoppingcart\Application\CartLineFactory;
use malotor\shoppingcart\Application\CartLineRepositoryInterface;
use malotor\shoppingcart\Domain\CartLineInterface;

class LineCartRepository implements CartLineRepositoryInterface {

  public function __construct($container) {
    $this->container = $container;
    $this->doctrine = $this->container->get('doctrine');
  }

  public function getAll() {
    $em = $this->doctrine->getManager();
    $cartLines = $em->getRepository('ShoppingCartBundle:CartLine')->findAll();
    $domainCartLines = [];
    foreach($cartLines as $cartLine) {
      $domainCartLines[] =CartLineFactory::create($cartLine->getItem(),$cartLine->getQuantity());
    }
    return $domainCartLines;
  }

  public function removeAll() {
    $em = $this->doctrine->getManager();
    $cartLines = $em->getRepository('ShoppingCartBundle:CartLine')->findAll();
    foreach ($cartLines as $removeCartLine) {
      $em->remove($removeCartLine);
    }
    $em->flush();
  }

  public function save(CartLineInterface $cartLine) {
    $em = $this->doctrine->getManager();
    $offer = $em->getRepository('OfertaBundle:Oferta')->find($cartLine->getItem()->getId());

    $cuponCartLine = new CartLine();
    //@todo add current user if we are logged
    $cuponCartLine->setUser(1);
    $cuponCartLine->setOffer($offer);
    $cuponCartLine->setQuantity($cartLine->getQuantity());

    $em->persist($cuponCartLine);
    $em->flush();

  }

} 