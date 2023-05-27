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

    public function scopeSearch($query, $search)
    {
        if($search !== null){
            $search_split = mb_convert_kana($search, 's'); //全角スペース半角に
            $search_split2 = preg_split('/[\s]+/', $search_split); //空白で区切る
            foreach($search_split2 as $value){
                $query->where(function($query) use ($value){ // 検索するカラムを複数指定
                    $query->where('title', 'like', '%'.$value.'%')
                    ->orWhere('id', 'like', '%'.$value.'%')
                    ->orWhere('contents', 'like', '%'.$value.'%')
                    ->orWhere('created_at', 'like', '%'.$value.'%');
                });
            }
            return $query;
        }
    }

    // public function scopeSearch($query, $search)
    // {
    // if($search !== null){
    //     $search_split = mb_convert_kana($search, 's');
    //     $search_split2 = preg_split('/[\s]+/', $search_split);
    //     foreach ($search_split2 as $value){
    //         $query->where('name', 'like', '%'. $value.'%');
    //     }
    // }
    // return $query;
}

