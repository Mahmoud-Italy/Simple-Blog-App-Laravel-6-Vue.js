<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Helper;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status','is_author','bcrypt_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



     // STATICS FUN
    public static function allMembers($requests)
    {
        return self::where(['is_admin'=>false, 'is_author'=>false])->orderBy('id', 'DESC')->paginate(20);
    }

    public static function allAuthors($requests)
    {
        return self::where(['is_admin'=>false, 'is_author'=>true])->orderBy('id', 'DESC')->paginate(20);
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



    public static function verifyAccount($key)
    {
        $obj = false;
        $row = self::where(['bcrypt_key'=> $key,'status'=>false])->count() ? self::where(['bcrypt_key'=> $key,'status'=>false])->first() : false;
        if($row) {
            $row->status = true;
            $row->bcrypt_key = NULL;
            $row->email_verified_at = date('Y-m-d H:i:s'); 
            $row->save();
            $obj = $row;
        }
        return $obj;
    }

    public static function getUserName($user_id)
    {
        $obj = '';
        $row = self::where('id', $user_id)->first();
        if($row) {
            $obj = $row->name;
        }
        return $obj;
    }

    public static function getPermissions($requests)
    {
        $obj = false;
        $user_id = Helper::whoIs($requests['accessToken']);
        $row = (\DB::table('roles')->where('user_id', $user_id)->count()) ? \DB::table('roles')->where('user_id', $user_id)->first() : NULL;
        if($row) {
            $obj = $row;
        }
        return $obj;
    }
}
