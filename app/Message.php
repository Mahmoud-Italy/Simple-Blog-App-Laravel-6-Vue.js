<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['name', 'email', 'message'];


    // STATICS FUN
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
            ($obj->status) ? '' : self::where(['id'=> $requests['id']])->update(['status'=>true]);
        }
        return $obj;
    }

    public static function destroy($requests)
    {
        $obj = false;
        if($row = self::show($requests)) {
            $row->delete();
            $obj = true;
        }
        return $obj;
    }

}
