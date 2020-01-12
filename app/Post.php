<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post_tag;
use Helper;
use DB;

class Post extends Model
{
    protected $fillable = ['user_id', 'image', 'title', 'content', 'status'];

    public function setUserIdAttribute($value)
    {
    	$this->attributes['user_id'] = Helper::whoIs($value);
    }

    public function setImageAttribute($value)
    {
        if(isset($value)) {
        	$path = '/uploads/posts/';
        	$fileName = Helper::uploadWithResize($value, $path, 800, 500);
        	$this->attributes['image'] = $fileName;
        }
    }

    // STATICS FUN
    public static function allDataActive($requests)
    {
        $data = DB::table('posts as p')
                            ->select('p.*')
                            ->where('p.status', true);

        if($requests['search']) {
            $data = $data->where('p.title','LIKE','%'.$requests['search'].'%');
        }

        if($requests['tag']) {
            $data = $data->leftjoin('post_tags as t', 't.post_id','=','p.id')
                                  ->where('t.tag', $requests['tag']);
        }

        $data = $data->orderBy('p.id','DESC')
                             ->paginate(20);

        return $data;
    }

    public static function allData($requests)
    {
    	return self::orderBy('id', 'DESC')->paginate(20);
    }

    public static function createOrUpdate($formatted_array) {
    	$affected_row = false;
	    $row = (isset($formatted_array['id'])) ? self::find($formatted_array['id']) : null;
	    if ($row === null) {
	        $row = self::create($formatted_array);
	        $affected_row = $row->id;
	    } else {
	        $row->update($formatted_array);
	        $affected_row =$formatted_array['id'];
	    }
	    return $affected_row;
	}

	public static function show($requests)
    {
        $obj = false;
        if(self::where(['id'=> $requests['id']])->count()) {
            $obj = self::where(['id'=> $requests['id']])->first();
        }
        return $obj;
    }

	public static function edit($requests)
    {
        $obj = false;
        $user_id = Helper::whoIs($requests['accessToken']);
        if(self::where(['id'=> $requests['id'], 'user_id' => $user_id])->count()) {
            $obj = self::where(['id'=> $requests['id'], 'user_id' => $user_id])->first();
        }
        return $obj;
    }

    public static function destroy($requests)
    {
        $obj = false;
        if($row = self::edit($requests)) {
            ($row->image) ? \File::Delete($row->image) : '';
            Post_tag::where('post_id', $row->id)->delete();
            $row->delete();
            $obj = true;
        }
        return $obj;
    }

    public static function getPostImage($post_id)
    {
    	$obj = false;
    	$row = self::where('id', $post_id)->first();
    	if($row) {
    		$obj = $row->image;
    	}
    	return $obj;
    }


}
