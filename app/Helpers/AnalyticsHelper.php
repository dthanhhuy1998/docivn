<?php
namespace App\Helpers;

class AnalyticsHelper
{
    static function randomUserOnline() {
        $session = date('h:i A', strtotime(date('Y-m-d H:i:s')));
        $time = new \DateTime($session); 
        $data = substr($time->format('H:i'), 0, 2);
        
        $userOnline = 0;
        if($data < 24) {
            $userOnline = rand(100, 200);
        }
        if($data < 23) {
            $userOnline = rand(200, 750);
        }
        if($data < 11) {
            $userOnline = rand(100, 200);
        }

        return $userOnline;
    }
}