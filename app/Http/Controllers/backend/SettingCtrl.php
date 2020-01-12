<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Setting as SettingResource;
use App\AppSetting;

class SettingCtrl extends Controller
{

    public function index(Request $request)
    {
    	$data = new SettingResource(AppSetting::find(1));
    	return self::respondSuccess($data);
    }

    public function update(Request $request)
    {
    	$row = AppSetting::createOrUpdate($request->all());
    	if($row) {
    		return self::respondSuccess();
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

}
