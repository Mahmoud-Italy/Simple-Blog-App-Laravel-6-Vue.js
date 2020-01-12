<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Member as MemberResource;
use App\User;

class MemberCtrl extends Controller
{
    
    public function index(Request $request)
    {
    	$data = MemberResource::collection(User::allMembers($request->all()));
    	$collection = ['data'=>$data, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function store(Request $request)
    {
    	$row = User::createOrUpdate($request->all());
    	if($row) {
    		return self::respondCreated();
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function edit(Request $request)
    {
    	$row = new MemberResource(User::edit($request->all()));
    	if($row) {
    		return self::respondSuccess($row);
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function destroy(Request $request)
    {
    	$row = User::destroy($request->all());
    	if($row) {
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

}
