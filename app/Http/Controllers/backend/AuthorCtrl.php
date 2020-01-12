<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Author as AuthorResource;
use App\User;
use App\Role;

class AuthorCtrl extends Controller
{
    public function index(Request $request)
    {
    	$data = AuthorResource::collection(User::allAuthors($request->all()));
    	$collection = ['data'=>$data, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function store(Request $request)
    {
    	$row = User::createOrUpdate($request->all());
    	if($row) {
    		Role::insertRoles($row, $request->all());
    		return self::respondCreated();
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function edit(Request $request)
    {
    	$row = new AuthorResource(User::edit($request->all()));
    	if($row) {
    		return self::respondSuccess($row);
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function destroy(Request $request)
    {
    	$row = User::destroy($request->all());
    	if($row) {
    		Role::destroy($row);
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function permissions(Request $request)
    {
        $row = User::getPermissions($request->all());
        if($row) {
            return self::respondSuccess($row);
        }
        
        return self::respondSomethingWrong('Something went wrong.');
    }
}
