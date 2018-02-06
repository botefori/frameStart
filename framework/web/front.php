<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use YaiLay\Framework;
use Symfony\Component\EventDispatcher\EventDispatcher;
use \Symfony\Component\HttpFoundation\RequestStack;
use \Symfony\Component\HttpKernel\EventListener\RouterListener;

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}


$request = Request::createFromGlobals();
$requestStack = new RequestStack();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));

$controllerResolver= new ControllerResolver();
$argumentsResolver= new ArgumentResolver();

$framework = new Framework($dispatcher, $controllerResolver, $requestStack, $argumentsResolver);
$response=$framework->handle($request);

$response->send();
