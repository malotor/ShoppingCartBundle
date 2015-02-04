<?php
namespace Cupon\ShoppingCartBundle\Services\Adapters;
use malotor\shoppingcart\Application\CartLineRepositoryInterface;
use malotor\shoppingcart\Domain\CartLineInterface;

class StrategyLineCartRepository implements CartLineRepositoryInterface {
  private $cartLineRepository;

  public function __construct($container) {

    $this->container = $container;
    $userLogged = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');

    if (!$userLogged) {
      $this->cartLineRepository = new SessionLineCartRepository($this->container);
    } else {
      $this->cartLineRepository = new DBLineCartRepository($this->container);
    }

  }

  public function getAll() {
    return $this->cartLineRepository->getAll();
  }

  public function removeAll() {
    $this->cartLineRepository->removeAll();
  }

  public function save(CartLineInterface $cartLine) {
    $this->cartLineRepository->save($cartLine);
  }
} 