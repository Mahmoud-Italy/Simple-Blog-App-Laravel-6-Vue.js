<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Helper;

class Comment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'comment'];

    public function setUserIdAttribute($value)
    {
    	$this->attributes['user_id'] = Helper::whoIs($value);
    }

     // STATICS FUN
    public static function allData($requests)
    {
    	return self::orderBy('id', 'DESC')->paginate(20);
    }

    public static function allDataBelongTo($requests)
    {
    	return self::where('post_id', $requests['post_id'])->orderBy('id', 'ASC')->paginate(20);
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


    public static function edit($requests)
    {
        $obj = false;
        if(self::where(['id'=> $requests['id']])->count()) {
            $obj = self::where(['id'=> $requests['id']])->first();
        }
        return $obj;
    }

    public static function destroy($requests)
    {
        $obj = false;
        if($row = self::edit($requests)) {
            $row->delete();
            $obj = true;
        }
        return $obj;
    }

}
