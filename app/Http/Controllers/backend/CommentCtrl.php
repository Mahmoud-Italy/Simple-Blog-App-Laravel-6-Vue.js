<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Comment;

class CommentCtrl extends Controller
{

    public function index(Request $request)
    {
    	$data = CommentResource::collection(Comment::allData($request->all()));
    	$collection = ['data' => $data, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function destroy(Request $request)
    {
    	$row = Comment::destroy($request->all());
    	if($row) {
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

}
