<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    //ブックマーク登録
    public function store($task_id)
    {
        $bookmark= new Bookmark();
        $bookmark->task_id=$task_id;
        $bookmark->user_id=Auth::user()->id;
        $bookmark->save();

        return redirect('/todo');

    }
    //ブックマーク削除
    public function destroy($bookmark_id)
    {
        $bookmark= Bookmark::find($bookmark_id);
        $bookmark->delete();
        return redirect('/todo');
    }

     //ブックマーク削除
     public function destroy2($bookmark_id)
     {
         $bookmark= Bookmark::find($bookmark_id);
         $bookmark->delete();
         return redirect('/todo/bookmark');
     }

    // //ブックマークの表示
    public function index()
    {
       $bookmarks = Bookmark::with('task')->latest()->paginate(8);
       return view('todo.bookmark', compact('bookmarks'));
    
    }
 }     
