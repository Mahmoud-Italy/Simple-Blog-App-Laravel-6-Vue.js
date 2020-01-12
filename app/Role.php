<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['user_id', 'creates', 'shows', 'updates', 'deletes'];

    public static function insertRoles($user_id, $requests)
    {
    	$data[] = [
    		'user_id' => $user_id,
    		'creates' => $requests['creates'],
    		'shows' => $requests['shows'],
    		'updates' => $requests['updates'],
    		'deletes' => $requests['deletes'],
    	];
    	self::where('user_id', $user_id)->delete();
    	self::insert($data);
    }

    public static function getRoles($user_id, $select)
    {
    	$obj = false;
    	$row = (self::where('user_id', $user_id)->count()) ? 
    				self::where('user_id', $user_id)->first() : NULL;
    	if($row && $row->$select) {
    		$obj = true;
    	}
    	return $obj;
    }

    public static function destroy($user_id)
    {
    	self::where('user_id', $user_id)->delete();
    }


}
