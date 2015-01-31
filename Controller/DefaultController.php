<?php

namespace Cupon\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Cupon\ShoppingCartBundle\Services\Printer;
use Symfony\Component\HttpFoundation\RedirectResponse;

use malotor\shoppingcart\Application\Ecommerce;

use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends Controller
{

  private $printer;

  public function __construct(ContainerInterface $ecommerce)
  {
    $this->ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    $this->printer = $this->container->get('cupon_shopping_cart.printer');
    $this->request = $this->container->get('request');
  }

  public function addToCartAction($id)
  {
    try {
      $this->ecommerce->addProductToCart($id);
      return $this->redirectPreviousPage('Offer added to cart');
    } catch (Exception $e) {
      return $this->redirectPreviousPage($e->getMessage(),'error');
    }
  }

  public function removeFromCartAction($id)
  {
    try {
      $this->ecommerce->removeProductFromCart($id);
      return $this->redirectPreviousPage('Offer removed to cart');
    } catch (Exception $e) {
      return $this->redirectPreviousPage($e->getMessage(),'error');
    }
  }

  public function boxShoppingCart() {
    return $this->renderShoppingCart('block');
  }

  public function showCartAction()
  {
    return $this->renderShoppingCart('full');
  }

  protected function renderShoppingCart($display = 'block') {

    $this->printer->setShoppingCart($this->ecommerce->getCartItems());
    $this->printer->setTotalAmunt($this->ecommerce->getCartTotalAmunt());

    return $this->printer->render($display);
  }

  protected function redirectPreviousPage($message, $type= 'notice') {
    $this->request->getSession()->getFlashBag()->add($type, $message);
    return $this->redirect($this->generateUrl('portada'));
  }
  /*
   * $url = $this->getRequest()->headers->get("referer");
        return new RedirectResponse($url);
   */

}
