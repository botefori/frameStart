<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LeapYearController
{
    public function IndexAction(Request $request)
    {
        if(is_leap_year($request->attributes->get('year'))){
            return new Response('Yep, this year is a leap!');
        }

        return new Response('Nope, this is not a leap year.');
    }
}