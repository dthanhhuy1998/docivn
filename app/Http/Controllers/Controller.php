<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use SEOMeta;
use OpenGraph;
use JsonLd;
use Artesaos\SEOTools\Facades\TwitterCard;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateSKU() {
        return substr(time(), -8);
    }

    public function seo_tools($title, $description, $keyword, $image, $url) {
        SEOMeta::setTitle($title)
        ->setDescription($description)
        ->addKeyword($keyword);

        OpenGraph::setTitle($title)
        ->setDescription($description)
        ->addImage($image)
        ->setUrl($url)
        ->setSiteName($title);

        TwitterCard::setTitle($title)
        ->setDescription($description)
        ->setUrl($url)
        ->setImage($image)
        ->setType('website')
        ->setSite($title);

        JsonLd::setType('perfume')
        ->setImage($image)
        ->setTitle($title)
        ->setDescription($description)
        ->setUrl($url)
        ->setSite($url);
    }
}
