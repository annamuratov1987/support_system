<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'complaints';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'theme', 'message', 'file_path'
    ];

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
