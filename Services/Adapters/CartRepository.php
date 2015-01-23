<?php

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use Symfony\Component\HttpFoundation\Session\Session;

use malotor\shoppingcart\Ports\CartRepositoryInterface;
use malotor\shoppingcart\domain\Cart;

class CartRepository implements CartRepositoryInterface {

  public function __construct($container) {
    $this->container = $container;
    $this->request = $this->container->get('request');
    $this->session = $this->request->getSession();
  }

  public function get() {
    $cart = new Cart();
    if ($shoppingCart = $this->session->get('shoppingCart')) $cart =  $shoppingCart;
    return $cart;
  }

  public function save($shoppingCart) {
    $this->session->set (
      'shoppingCart',
       $shoppingCart
    );
  }

}