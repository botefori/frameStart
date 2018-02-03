<?php


namespace YaiLay;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentLengthListener implements EventSubscriberInterface
{


    public function  onResponse(ResponseEvent $responseEvent)
    {

            $response = $responseEvent->getResponse();

            $headers = $responseEvent->getResponse()->headers;

            if(!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')){

                $response -> headers->set('Content-Length', strlen($response->getContent()));

            }
    }

    public static function getSubscribedEvents()
    {
       return array('response' => array('onResponse', -255));
    }


}