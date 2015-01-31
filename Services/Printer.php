<?php
/**
 * Created by PhpStorm.
 * User: manel
 * Date: 29/01/15
 * Time: 22:40
 */

namespace Cupon\ShoppingCartBundle\Services;


class Printer {
  protected $cartLines;
  protected $amount;

  public function __construct($templating) {
    $this->templating = $templating;
  }

  public function setShoppingCart($cartLines) {
    $this->cartLines = $cartLines;
  }
  public function setTotalAmunt($amount) {
    $this->amount = $amount;
  }

  public function render($display = 'block') {

    $cartItems = [];
    foreach($this->cartLines as $delta => $cartLine) {
      $cartItems[$delta]['item']= $cartLine->getItem();
      $cartItems[$delta]['quantity']= $cartLine->getQuantity();
    }

    return $this->templating->renderResponse('ShoppingCartBundle:Default:shoppingCart.'. $display.'.html.twig',[
      'cartItems' => $cartItems,
      'totalAmount' => $this->amount
    ]);
  }
} 