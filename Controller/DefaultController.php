<?php

namespace Cupon\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class DefaultController extends Controller
{
  public function addToCartAction($id)
  {
    $ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    try {
      $ecommerce->addProductToCart($id);
      $cartItems = $ecommerce->getCartItems();
      var_dump($cartItems);
    } catch (Exception $e) {

    }
  }
  public function removeFromCartAction($id)
  {
    $ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    try {
      $ecommerce->removeProductFromCart($id);
      $cartItems = $ecommerce->getCartItems();
      var_dump($cartItems);
    } catch (Exception $e) {

    }
  }
  public function boxShoppingCart($id) {
    return "<h2>Shopping Cart</h2>";
  }
}
