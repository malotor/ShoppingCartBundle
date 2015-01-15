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
      /*
      $request = $this->getRequest();

      $this->container->get("session")->setFlash("error", "Pikachu is not allowed");
      $url = $this->getRequest()->headers->get("referer");

      return new RedirectResponse($url);
      */

    } catch (Exception $e) {

    }
  }
  public function removeFromCartAction($id)
  {
    $ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    try {
      $ecommerce->removeProductFromCart($id);
    } catch (Exception $e) {

    }
  }
  public function boxShoppingCart() {
    return "<h2>Shopping Cart</h2>";
  }
}
