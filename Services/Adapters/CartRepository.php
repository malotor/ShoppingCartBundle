<?php

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use Symfony\Component\HttpFoundation\Session\Session;

use malotor\shoppingcart\Ports\CartRepositoryInterface;
use malotor\shoppingcart\domain\Cart;

class CartSessionRepository implements CartRepositoryInterface {

  public function get() {
    $cart = new Cart();
    $session = new Session();

    if ($shoppingCart = $session->get ('shoppingCart')) $cart = unserialize ($shoppingCart);

    return $cart;
  }

  public function save($shoppingCart) {

    $session = new Session();
    $session->set (
      'shoppingCart',
      serialize ($shoppingCart)
    );

    $session->save ();

  }

}