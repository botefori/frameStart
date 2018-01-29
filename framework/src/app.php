<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();

$routes->add('hello', new Route('/hello/{name}', array('name' => 'world')));
$routes->add('bye', new Routing\Route('/bye'));

return $routes;