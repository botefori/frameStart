<?php


namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ByeController
{
    public function indexAction(Request $request)
    {
        $request -> attributes -> set('foo', 'bar');

        $response = render_template($request);

        $response->headers->set('content-Type', 'text/plain');

        return $response;
    }
}