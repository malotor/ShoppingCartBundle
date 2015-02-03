<?php
/**
 * Created by PhpStorm.
 * User: manel
 * Date: 15/01/15
 * Time: 17:31
 */

namespace Cupon\ShoppingCartBundle\Services\Adapters;

use malotor\shoppingcart\Application\ItemRepositoryInterface;
use malotor\shoppingcart\Application\ItemFactory;

class ItemRepository implements ItemRepositoryInterface {

  public function __construct($container) {
    $this->container = $container;
    $this->doctrine = $this->container->get('doctrine');
  }

  public function get($id) {
    $em = $this->doctrine->getManager();
    $oferta = $em->getRepository('OfertaBundle:Oferta')->find($id);

    $item = ItemFactory::create(
      $oferta->getId(),
      $oferta->getNombre(),
      $oferta->getSlug(),
      $oferta->getDescripcion(),
      $oferta->getPrecio()
    );

    return $item;
  }
} 