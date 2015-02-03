<?php

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use malotor\shoppingcart\Application\CartLineFactory;
use malotor\shoppingcart\Application\CartLineRepositoryInterface;
use malotor\shoppingcart\Domain\CartLineInterface;

class SessionLineCartRepository implements CartLineRepositoryInterface {

  public function __construct($container) {
    $this->container = $container;
    $this->session = $this->container->get('session');
    $this->itemRepository = $this->container->get('cupon_shopping_cart.product_repository');
  }

  public function getAll() {
    $cartLines = $this->session->get('cartLines', array());

    $domainCartLines = [];
    foreach($cartLines as $cartLine) {
      $item = $this->itemRepository->get($cartLine['id']);
      $domainCartLines[] = CartLineFactory::create($item,$cartLine['quantity']);
    }
    return $domainCartLines;
  }

  public function removeAll() {
    $this->session->set('cartLines', array());
  }

  public function save(CartLineInterface $cartLine) {

    $cartLineArray['id'] = $cartLine->getItem()->getId();
    $cartLineArray['quantity'] = $cartLine->getQuantity();

    $cartLines = $this->session->get('cartLines', array());

    $cartLines[] = $cartLineArray;

    $this->session->set('cartLines', $cartLines);
  }

} 