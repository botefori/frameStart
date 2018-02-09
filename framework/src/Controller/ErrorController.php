<?php
declare(strict_types=1);

namespace Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
  public  function exceptionAction(FlattenException $exception)
  {
      $msg = 'Something went wrong ! ( '.$exception -> getMessage().' )';


      $response =(new Response($msg, $exception -> getStatusCode()));
      $response->headers->set('content-Type', 'text/plain');
      return $response;
  }
}