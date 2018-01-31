<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

require_once __DIR__.'/Controller/HelloController.php';
require_once __DIR__.'/Controller/LeapYearController.php';

function is_leap_year($year = null)
{
    if (null === $year) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
        'year' => null,
        '_controller' => 'Controller\LeapYearController::indexAction',
    ]
));
$routes->add('hello', new Route('/hello/{name}', [
            'name' => 'world',
            '_controller' => 'Controller\HelloController::indexAction',
        ]
    )
);
$routes->add('bye', new Route('/bye', [
    '_controller' => 'Controller\ByeController::indexAction',
    ]
));
return $routes;