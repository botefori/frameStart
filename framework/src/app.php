<?php

use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;

$routes = new Routing\RouteCollection();

$routes->add('hello', new Route('/hello/{name}', array('name' => 'world',
                                                                    '_controller' => function($request)
                                                                    {
                                                                        $request -> attributes -> set('foo', 'bar');

                                                                        $response = render_template($request);

                                                                        $response->headers->set('content-Type', 'text/plain');

                                                                        return $response;
                                                                    }
                                                                    )
                                        )
            );
$routes->add('bye', new Route('/bye', array('_controller' => function($request)
                                                                        {
                                                                            $request -> attributes -> set('foo', 'bar');

                                                                            $response = render_template($request);

                                                                            $response->headers->set('content-Type', 'text/plain');

                                                                            return $response;
                                                                        })));

return $routes;