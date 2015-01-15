<?php
/**
 * Created by PhpStorm.
 * User: manel
 * Date: 15/01/15
 * Time: 17:31
 */

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use malotor\shoppingcart\Ports\ProducRepositoryInterface;

class ProductRepository implements ProducRepositoryInterface{

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
    $this->doctrine = $this->container->get('doctrine');
  }

  public function get($id) {
    $em = $this->doctrine->getManager();
    $oferta = $em->getRepository('OfertaBundle:Oferta')->get($id);
    return $oferta;
  }
} 