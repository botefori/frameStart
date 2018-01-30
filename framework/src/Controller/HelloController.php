<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;


class HelloController
{
    public function indexAction(Request $request)
    {
        $request -> attributes -> set('foo', 'bar');

        $response = render_template($request);

        $response->headers->set('content-Type', 'text/plain');

        return $response;
    }
}