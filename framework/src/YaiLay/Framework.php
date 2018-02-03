<?php

namespace YaiLay;

use Psr\Log\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework implements HttpKernelInterface
{
    /** @var EventDispatcher $dispatcher */
    private $dispatcher;
    /** @var  UrlMatcher $matcher */
    protected $matcher;
    /** @var  ControllerResolver $controllerResolver */
    protected $controllerResolver;
    /** @var  ArgumentResolver $argumentsResolver */
    protected $argumentsResolver;

    public function __construct(EventDispatcher $dispatcher, UrlMatcherInterface $matcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentsResolver)
    {
        $this->dispatcher=$dispatcher;
        $this->matcher=$matcher;
        $this->controllerResolver=$controllerResolver;
        $this->argumentsResolver=$argumentsResolver;
    }

    public function handle(Request $request, $type=HttpKernelInterface::MASTER_REQUEST, $catch=true)
    {
        $this->matcher->getContext()->fromRequest($request);

        try
        {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentsResolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);
        }catch (RouteNotFoundException $re)
        {
           $response = new Response('Not Found', 404);

        }catch (InvalidArgumentException $invarg) {
          $response = new Response($invarg->getMessage(), 500);
        }
        catch (\Exception $e)
        {
             $response = new Response('An error occurred ', 500);
        }

        $this->dispatcher->dispatch('response', new ResponseEvent($request, $response));

        return $response;
    }
}