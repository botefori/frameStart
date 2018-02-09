<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use YaiLay\StringResponseListener;
use \Symfony\Component\DependencyInjection\ContainerBuilder;
use \Symfony\Component\DependencyInjection\Reference;

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}




$request = Request::createFromGlobals();

/** @var ContainerBuilder $yc */
$yc = include __DIR__.'/../src/container.php';

$yc -> setParameter('routes', include __DIR__.'/../src/app.php');
$yc -> setParameter('charset', 'UTF-8');

$yc -> register('listener.string_listener', StringResponseListener::class);
$yc -> getDefinition('dispatcher')
    -> addMethodCall('addSubscriber', array( new Reference('listener.string_listener')));


$response = $yc -> get('framework') -> handle($request);

$response -> send();



