<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostTag as TagResource;
use App\Http\Resources\Comment as CommentResource;
use App\Post;
use App\Post_tag;
use App\Comment;
use App\Message;

class AppCtrl extends Controller
{

    public function index(Request $request)
    {
    	$data = PostResource::collection(Post::allDataActive($request->all()));
    	$tags = TagResource::collection(Post_tag::allDataDistinct($request->all()));
    	$collection = ['data'=>$data, 'tags'=>$tags, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function show(Request $request)
    {
    	$data = new PostResource(Post::show($request->all()));
    	return self::respondSuccess($data);
    }

    public function comments(Request $request)
    {
    	$data = CommentResource::collection(Comment::allDataBelongTo($request->all()));
    	$collection = ['data'=>$data, 'meta' => self::getMeta($data)];
    	return self::respondSuccess($collection);
    }

    public function createComment(Request $request)
    {
    	$row = Comment::create(self::replaceArrayKey($request->all(), 'accessToken', 'user_id'));
    	if($row) {
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function destroyComment(Request $request)
    {
    	$row = Comment::destroy($request->all());
    	if($row) {
    		return self::respondSuccess();
    	}
    	
    	return self::respondSomethingWrong('Something went wrong.');
    }

    public function contact(Request $request)
    {
    	if(!$request->name || !$request->email || !$request->message) {
    		return self::respondValidationError('Parameter is required.');
    	}

    	if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
    		return self::respondValidationError('Invalid Email Address.');
    	}

    	$row = Message::create($request->all());
    	if($row) {
    		return self::respondCreated();
    	}

    	return self::respondSomethingWrong('Something went wrong.');
    }

}
