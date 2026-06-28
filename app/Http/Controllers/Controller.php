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

    public function seo_tools($title, $description, $keyword, $image, $url, $type = 'website') {
        $url = $url ?? url()->current();
        $title = $title ?? '';
        $description = $description ?? '';
        $keyword = $keyword ?? '';
        $image = $image ?? '';

        SEOMeta::setTitle($title)
        ->setDescription($description)
        ->addKeyword($keyword)
        ->setCanonical($url);

        OpenGraph::setTitle($title)
        ->setDescription($description)
        ->addImage($image, [
            'width' => '1200',
            'height' => '630',
        ])
        ->setUrl($url)
        ->setSiteName($title);

        TwitterCard::setTitle($title)
        ->setDescription($description)
        ->setUrl($url)
        ->setImage($image)
        ->setType('summary_large_image')
        ->setSite($title);

        JsonLd::setType($type)
        ->addImage($image, [
            'width' => '1200',
            'height' => '630',
        ])
        ->setTitle($title)
        ->setDescription($description)
        ->setUrl($url)
        ->setSite($url);
    }
}
