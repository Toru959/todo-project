<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'contents',
        'file', 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function bookmarks()
    {
        return $this->hasMany('App\Models\Bookmark');
    }


    public function likedBy($user)
    {
        return Bookmark::where('user_id',$user->id)->where('task_id',$this->id);
    }

}

