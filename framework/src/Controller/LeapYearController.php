<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LeapYearController
{
    public function IndexAction(Request $request)
    {
        if(is_leap_year($request->attributes->get('year'))){
            $response = 'Yep, this year is a leap!  ';
        }


        $response = 'Nope, this is not a leap year';



        return $response;
    }
}