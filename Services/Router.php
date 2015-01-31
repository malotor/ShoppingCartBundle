<?php
/**
 * Created by PhpStorm.
 * User: manel
 * Date: 31/01/15
 * Time: 09:56
 */

namespace Cupon\ShoppingCartBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Router {
  public function __construct(Request $request) {
    $this->request = $request;
  }
  public function redirectPreviousPage($message) {
    return $this->doRedirection($message,'notice');
  }

  public function redirectPreviousPageError(\Exception $exception) {
    return $this->doRedirection($exception->getMessage(),'error');
  }

  protected function doRedirection($message,$type) {
    $referer = $this->request->headers->get('referer');
    $this->request->getSession()->getFlashBag()->add($type, $message);
    return new RedirectResponse($referer);
  }
} 