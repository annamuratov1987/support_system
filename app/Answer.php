<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'complaint_id', 'text', 'file_path'
    ];

    public function author(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
