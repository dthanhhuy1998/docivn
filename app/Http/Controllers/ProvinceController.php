<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\District;
use App\Models\Ward;

class ProvinceController extends Controller
{
    public function getDistrictByProvinceId(Request $request) {
        $districts = District::where('matp', $request->provinceId)
        ->orderBy('name', 'asc')
        ->get();

        $data = '';
        if($request->provinceId != '') {
            foreach($districts as $district) {
                $data .= '<option value="'. $district->maqh .'">'. $district->name.'</option>';
            }
        } else {
            $data = '<option value="">-- Chọn Quận/Huyện --</option>';
        }

        return response()->json([
            'status'    => 200,
            'data'      => $data
        ]);
    }

    public function getWardByDistrictId(Request $request) {
        $wards = Ward::where('maqh', $request->districtId)
        ->orderBy('name', 'asc')
        ->get();

        $data = '';

        if($request->districtId != '') {
            foreach($wards as $ward) {
                $data .= '<option value="'. $ward->xaid .'">'. $ward->name.'</option>';
            }
        } else {
            $data = '<option value="">-- Chọn Xã/Thị Trấn --</option>';
        }

        return response()->json([
            'status'    => 200,
            'data'      => $data
        ]);
    }
}
