<?php
/**
 * Created by PhpStorm.
 * User: manel
 * Date: 15/01/15
 * Time: 17:31
 */

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use malotor\shoppingcart\Ports\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface{

  public function __construct($container) {
    $this->container = $container;
    $this->doctrine = $this->container->get('doctrine');
  }

  public function get($id) {
    $em = $this->doctrine->getManager();
    $oferta = $em->getRepository('OfertaBundle:Oferta')->find($id);
    return $oferta;
  }
} 