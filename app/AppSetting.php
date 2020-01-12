<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'logo', 'title', 'email', 'mobile',
    ];

    public static function createOrUpdate($formatted_array) {
    	$affected_row = false;
	    $row = self::find(1);
	    $row->update($formatted_array);
	    return true;
	}
}
