<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;

class DashCtrl extends Controller
{
    
    public function index(Request $request)
    {
    	$dataChart = [];

    	for ($i = 01; $i <= 12; $i++) { 
    		$dataChart[] = Helper::chartMonth($i);
    	}

        $data = ['dataChart'=>$dataChart];
        return self::respondSuccess($data);
    }

    public function rowStatus(Request $request)
    {
        $namespace = '\\App\\';
        $model = $namespace . $request->modelName;

            // ValidateToken
            if(!self::validateToken($request->accessToken)) {
                return self::validateToken($request->accessToken);
            } 

        
    		if($model::where('id', $request->rowId)->count()) {
    	    	$row = $model::where('id', $request->rowId)->first();
    	    	$row->status = ($row->status == 1) ? 0 : 1;
    	    	$row->save();
                $statusCode = 200;
	    	}
        
    	return response()->json(['statusCode'=>200]);
    }
}
