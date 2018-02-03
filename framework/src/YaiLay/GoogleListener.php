<?php


namespace YaiLay;


class GoogleListener
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

}