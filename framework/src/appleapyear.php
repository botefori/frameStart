<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

$routes =  new Routing\RouteCollection();

$routes->add('leap_year', new Route('/is_leap_year/{year}', [
                                                                            'year' => null,
                                                                            '_controller' => function($request)
                                                                                    {
                                                                                        if(is_leap_year($request->attributes->get('year'))){
                                                                                            return new Response('Yep, this year is a leap!');
                                                                                        }

                                                                                        return new Response('Nope, this is not a leap year.');
                                                                                    }
                                                                        ]
));

return $routes;