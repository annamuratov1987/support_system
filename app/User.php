<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function complaints()
    {
        return $this->hasMany('App\Complaint');
    }

    public function isManager(){
        return $this->role == 'manager';
    }

    public function isCreateComplaintInDay(){
        $today = date('Y-m-d H:i:s', strtotime("today"));
        $complaint = Complaint::where('created_at', '>=', $today)->get();
        if ($complaint->isEmpty()){
            return false;
        }
        return true;
    }

    public static function getManagers(){
        $managers = User::where('role', '=', 'manager')->get();
        return $managers;
    }
}
