<?php

namespace YaiLay;

use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework
{
    /** @var  UrlMatcher $matcher */
    protected $matcher;
    /** @var  ControllerResolver $controllerResolver */
    protected $controllerResolver;
    /** @var  ArgumentResolver $argumentsResolver */
    protected $argumentsResolver;

    public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentsResolver)
    {
        $this->matcher=$matcher;
        $this->controllerResolver=$controllerResolver;
        $this->argumentsResolver=$argumentsResolver;
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try
        {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentsResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        }catch (RouteNotFoundException $re)
        {
           return $response = new Response('Not Found', 404);

        }catch (InvalidArgumentException $invarg) {
          return  $response = new Response($invarg->getMessage(), 500);
        }
        catch (\Exception $e)
        {
            return $response = new Response('An error occurred ', 500);
        }
    }
}