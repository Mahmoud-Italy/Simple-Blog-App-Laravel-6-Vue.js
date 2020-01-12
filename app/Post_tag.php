<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_tag extends Model
{
	//

    public static function insertArray($post_id, $array='')
    {
    	if(isset($array)) {
            $obj = [];
            foreach ($array as $key => $value) {
                if(isset($value)) {
                    $obj[] = [
                        'post_id' => $post_id,
                        'tag' => (isset($value)) ? $value : NULL
                    ];
                }
            } 
            self::where('post_id',$post_id)->delete();
            self::insert($obj); 
        }
    }

    public static function getTags($post_id)
    {
    	return self::select('id as tag_id','tag as value')->where('post_id', $post_id)->get();
    }

    public static function allData($requests)
    {
        return self::orderBy('id','DESC')->get();
    }

    public static function allDataDistinct($requests)
    {
       return self::select('tag')->groupBy('tag')->get();
    }
}
