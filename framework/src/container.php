<?php
declare(strict_types=1);

use YaiLay\Framework;
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher;

$yc = new DependencyInjection\ContainerBuilder();

$yc -> register('context', Routing\RequestContext::class);
$yc -> register('matcher', Routing\Matcher\UrlMatcher::class)
    -> setArguments(array('%routes%', new Reference('context')));

$yc -> register('request_stack', HttpFoundation\RequestStack::class);
$yc -> register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
$yc -> register('arguments_resolver', HttpKernel\Controller\ArgumentResolver::class);

$yc -> register('listener.router', HttpKernel\EventListener\RouterListener::class)
    -> setArguments(array(new Reference('matcher'), new Reference('request_stack')));

$yc -> register('listener.response', HttpKernel\EventListener\ResponseListener::class)
    -> setArguments(array('%charset%'));

$yc -> register('listener.exception', HttpKernel\EventListener\ExceptionListener::class)
    -> setArguments(array('Controller\ErrorController::exceptionAction'));

$yc -> register('dispatcher', EventDispatcher\EventDispatcher::class)
    -> addMethodCall('addSubscriber', array(new Reference('listener.router')))
    -> addMethodCall('addSubscriber', array(new Reference('listener.response')))
    -> addMethodCall('addSubscriber', array(new Reference('listener.exception')));

$yc -> register('framework', Framework::class)
    -> setArguments(array(
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('arguments_resolver')
    ));

return $yc;

