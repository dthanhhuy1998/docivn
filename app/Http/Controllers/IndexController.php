<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

// Models
use App\Models\Product;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Article;

class IndexController extends Controller
{
    public function index() {
        $productTotal = Product::count();
        $articleTotal = Article::count();

        $pFavorites = Product::orderBy('viewed', 'desc')->limit(6)->get();
        $aFavorites = Article::orderBy('view', 'desc')->limit(6)->get();

        // access analytics
        $accessTotal = DB::table('truycap')->count();
        $online = DB::table('useronline')->distinct()->count('ip');

        // visit every day
        $countVisitedJSON = json_encode($this->countVisitByDay(date('Y-m-d'), 15));
        $visitsLabelJSON = json_encode($this->dayLabels(date('Y-m-d'), 15));

        $headingTitle = heading('Trang chính');
        $titlePage = 'Trang chính';

        return view('admin.pages.index',
            compact(
                'headingTitle',
                'titlePage',
                'productTotal',
                'articleTotal',
                'pFavorites',
                'aFavorites',
                'online',
                'accessTotal',
                'online',
                'countVisitedJSON',
                'visitsLabelJSON'
            )
        );
    }

    public function dayLabels($date, $number) {
        $now = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $days = array();
        for($i = $number; $i >= 1; $i--) {
            $day = date('Y-m-d', strtotime('-'.$i.' day', strtotime($now)));
            $dayLabel = date_format(date_create($day), 'd/m');
            array_push($days, $dayLabel);
        }

        return $days;
    }

    public function countVisitByDay($date, $number) {
        $now = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $days = array();
        for($i = $number; $i >= 1; $i--) {
            $day = date('Y-m-d', strtotime('-'.$i.' day', strtotime($now)));
            $accessNumber = DB::table('truycap')->whereDate('created_at', $day)->count();
            array_push($days, $accessNumber);
        }

        return $days;
    }
}
