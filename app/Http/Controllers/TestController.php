<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;


class TestController extends Controller
{
    public function generateSlug() {
        $string = 'Áo Blouse bác sĩ dáng dài - tay dài nam, nữ các size S M L XL';
        dd(Str::slug($string, '-'));
    }
}
