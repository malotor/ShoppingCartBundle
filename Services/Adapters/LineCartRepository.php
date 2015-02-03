<?php

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use Cupon\ShoppingCartBundle\Entity\CartLine;
use malotor\shoppingcart\Application\CartLineFactory;
use malotor\shoppingcart\Application\CartLineRepositoryInterface;
use malotor\shoppingcart\Application\ItemFactory;
use malotor\shoppingcart\Domain\CartLineInterface;

class LineCartRepository implements CartLineRepositoryInterface {

  public function __construct($container) {
    $this->container = $container;
    $this->doctrine = $this->container->get('doctrine');
    $this->em = $this->doctrine->getManager();
    $this->itemRepository = $this->container->get('cupon_shopping_cart.product_repository');
    $this->cartLineRepository = $this->em->getRepository('ShoppingCartBundle:CartLine');

    $this->user = $this->container->get('security.context')->getToken()->getUser();

  }

  public function getAll() {
    $cartLines = $this->cartLineRepository->findAll();
    $domainCartLines = [];
    foreach($cartLines as $cartLine) {
      $oferta = $cartLine->getItem();
      $item = $this->itemRepository->get($oferta->getId());
      $domainCartLines[] = CartLineFactory::create($item,$cartLine->getQuantity());
    }
    return $domainCartLines;
  }

  public function removeAll() {
    $cartLines = $this->cartLineRepository->findAll();
    foreach ($cartLines as $removeCartLine) {
      $this->em->remove($removeCartLine);
    }
    $this->em->flush();
  }

  public function save(CartLineInterface $cartLine) {
    $offer = $this->em->getRepository('OfertaBundle:Oferta')->find($cartLine->getItem()->getId());
    $cuponCartLine = new CartLine();
    //@todo add current user if we are logged
    $cuponCartLine->setUser(1);
    $cuponCartLine->setOffer($offer);
    $cuponCartLine->setQuantity($cartLine->getQuantity());
    $this->em->persist($cuponCartLine);
    $this->em->flush();
  }

} 