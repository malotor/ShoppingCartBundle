<?php

namespace Cupon\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

  public function addToCartAction($id, Request $request)
  {
    $ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    try {
      $ecommerce->addProductToCart($id);
      $request->getSession()->getFlashBag()->add('notice', 'Offer added to cart');
      return $this->redirect($this->generateUrl('portada'));

    } catch (Exception $e) {
      $request->getSession()->getFlashBag()->add('error', $e->getMessage());
      return $this->redirect($this->generateUrl('portada'));
    }
  }

  public function removeFromCartAction($id, Request $request)
  {
    $ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    try {
      $ecommerce->removeProductFromCart($id);
      $request->getSession()->getFlashBag()->add('notice', 'Offer removed to cart');
      return $this->redirect($this->generateUrl('portada'));
    } catch (Exception $e) {
      $request->getSession()->getFlashBag()->add('error', $e->getMessage());
      return $this->redirect($this->generateUrl('portada'));
    }
  }

  public function boxShoppingCartAction(Request $request) {
    try {
      return $this->renderShoppingCart('block');

    } catch (Exception $e) {
      $request->getSession()->getFlashBag()->add('error', $e->getMessage());
      return $this->redirect($this->generateUrl('portada'));
    }
  }

  public function showCartAction(Request $request)
  {
    try {
      return $this->renderShoppingCart('full');
    } catch (Exception $e) {
      $request->getSession()->getFlashBag()->add('error', $e->getMessage());
      return $this->redirect($this->generateUrl('portada'));
    }
  }

  protected function renderShoppingCart($display = 'block') {

    $ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');

    $cartItems = [];
    foreach($ecommerce->getCartItems() as $delta => $cartLine) {
      $cartItems[$delta]['item']= $cartLine->getItem();
      $cartItems[$delta]['quantity']= $cartLine->getQuantity();
    }

    return $this->render('ShoppingCartBundle:Default:shoppingCart.'. $display.'.html.twig',[
      'cartItems' => $cartItems,
      'totalAmount' => $ecommerce->getCartTotalAmunt()
    ]);
  }

}
