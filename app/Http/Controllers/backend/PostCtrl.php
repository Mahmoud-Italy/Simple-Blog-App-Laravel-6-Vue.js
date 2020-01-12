<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Post;
use App\Post_tag;

class PostCtrl extends Controller
{

    public function index(Request $request)
    {
    	$data = PostResource::collection(Post::allData($request->all()));
    	$collection = ['data'=>$data, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function store(Request $request)
    {
    	$row = Post::createOrUpdate(self::replaceArrayKey($request->all(), 'accessToken', 'user_id'));
    	if($row) {
    		Post_tag::insertArray($row, $request->tags);
    		return self::respondCreated();
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function edit(Request $request)
    {
    	$row = new PostResource(Post::edit($request->all()));
    	if($row) {
    		return self::respondSuccess($row);
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function destroy(Request $request)
    {
    	$row = Post::destroy($request->all());
    	if($row) {
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

}
