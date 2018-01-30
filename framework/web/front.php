<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}


$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver= new ControllerResolver();
$argumentsResolver= new ArgumentResolver();
try {

    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller=$controllerResolver->getController($request);

    $arguments=$argumentsResolver->getArguments($request, $controller);

    $response = call_user_func_array($controller, $arguments);

} catch (Routing\Exception\RouteNotFoundException $re) {
    $response = new Response('Not Found', 404);
}catch (InvalidArgumentException $invarg) {
    $response = new Response($invarg->getMessage(), 500);
}
catch (Exception $e) {
    $response = new Response('An error occurred ', 500);
}
$response->send();
