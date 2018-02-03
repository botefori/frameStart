<?php


namespace YaiLay;


class ContentLengthListener
{


    public function  onResponse(ResponseEvent $responseEvent)
    {

            $response = $responseEvent->getResponse();

            $headers = $responseEvent->getResponse()->headers;

            if(!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')){

                $response -> headers->set('Content-Length', strlen($response->getContent()));

            }
    }
}