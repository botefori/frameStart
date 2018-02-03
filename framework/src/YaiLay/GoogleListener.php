<?php


namespace YaiLay;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleListener implements  EventSubscriberInterface
{


    public  function onResponse(ResponseEvent $responseEvent)
    {
        $response = $responseEvent->getResponse();

        if($response->isRedirection() || $response->headers->has('content-type') && false === strpos($response->headers->get('Content-Type'), 'html')
            && 'html' !== $responseEvent->getRequest()->getRequestFormat()){
            return;
        }

        $response->setContent($response->getContent().'  GA code');
    }

    public static function getSubscribedEvents()
    {
        return array('response' => 'onResponse');
    }


}