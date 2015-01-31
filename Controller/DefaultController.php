<?php

namespace Cupon\ShoppingCartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends Controller
{

  private $printer;
  private $router;
  private $ecommerce;

  const MESSAGE_ADD_ITEM = 'Offer added to cart';
  const MESSAGE_REMOVE_ITEM = 'Offer removed to cart';

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
    $this->ecommerce = $this->container->get('cupon_shopping_cart.ecommerce');
    $this->printer = $this->container->get('cupon_shopping_cart.printer');
    $this->router = $this->container->get('cupon_shopping_cart.router');
  }

  public function addToCartAction($id)
  {
    try {
      $this->ecommerce->addProductToCart($id);
      return $this->router->redirectPreviousPage(self::MESSAGE_ADD_ITEM);
    } catch (Exception $e) {
      return $this->router->redirectPreviousPageError($e);
    }
  }

  public function removeFromCartAction($id)
  {
    try {
      $this->ecommerce->removeProductFromCart($id);
      return $this->router->redirectPreviousPage(self::MESSAGE_REMOVE_ITEM);
    } catch (Exception $e) {
      return $this->router->redirectPreviousPageError($e);
    }
  }

  public function renderShoppingCart($display = 'block') {
    $this->printer->setShoppingCart($this->ecommerce->getCartItems());
    $this->printer->setTotalAmunt($this->ecommerce->getCartTotalAmunt());
    return $this->printer->render($display);
  }

}
