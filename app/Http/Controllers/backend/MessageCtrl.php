<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Message as MessageResource;
use App\Message;

class MessageCtrl extends Controller
{
    
    public function index(Request $request)
    {
    	$data = MessageResource::collection(Message::allData($request->all()));
    	$collection = ['data' => $data, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function show(Request $request)
    {
    	$row = new MessageResource(Message::show($request->all()));
    	if($row) {
    		return self::respondSuccess($row);
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function destroy(Request $request)
    {
    	$row = Message::destroy($request->all());
    	if($row) {
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

}
