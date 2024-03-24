<?php
    function heading($routeName) {
        return $routeName . ' &lsaquo; Quản trị DOCI Perfume';
    }

    function datetime_vi($date) {
        return date_format(date_create($date), 'd/m/Y H:i:s');
    }

    function date_vi($date) {
        return date_format(date_create($date), 'd/m/Y');
    }

    function date_string($date) {
        $day = date_format(date_create($date), 'd');
        $month = date_format(date_create($date), 'm');
        $year =  date_format(date_create($date), 'Y');
        return $day . ' tháng ' . $month . ', ' . $year;
    }

    function discountPercent($originalPrice, $price) {
        if($originalPrice > 0) {
            return 100 - ($price * 100)/$originalPrice;
        }
    }

    function tra_truoc($gia_san_pham, $phan_tram) {
        return $gia_san_pham * ($phan_tram/100);
    }

    function so_tien_vay($gia_san_pham, $tra_truoc) {
        return $gia_san_pham - $tra_truoc;
    }

    function tien_gop($tien_vay, $thang) {
        if($thang == 6) {
            $x1 = $tien_vay/$thang;
            $x2 = $tien_vay*0.005;
            $x3 = 0;
        } else {
            $x1 = $tien_vay/$thang;
            $x2 = $tien_vay*0.005;
            $x3 = $tien_vay*0.0189;
        }

        return ceil(($x1 + $x2 + $x3) + 12000);
    }

    function pathResolution($url) {
        return str_replace('https://www.youtube.com/watch?v=', '', $url);
    }
?>