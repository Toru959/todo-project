<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create($id)
    {
        $task = Task::find($id);
        return view('todo.comment', compact('task'));
    }

    public function store(Request $request, $id) //第二引数に＄idを追加。パラメーターのidを受け取れる
    {
        $task = Task::findOrFail($id); //パラメーターのidでt一致するaskのレコードをとってくることでuser_idを指定できる。
        
        // $task = Task::find($request->task_id);
        $comment = new Comment;
        $comment -> contents = $request -> contents;
        $comment -> user_id = Auth::id(); // 現在ログインしているユーザー
        $comment -> task_id = $id; // パラメーターがそのままtask_idになる
        $comment -> save(); 
        
        // return redirect()->route('todo.show');
        return redirect()->route('todo.show',$id); //とりあえずindexに戻るようにしてる
    }

    // public function show($id)
    // {
    //     $comments = Comment::find($id);
    //     // dd($comments);
    //     return view('todo.show', compact('comments'));
        
    // } 

    public function destroy($id)
    {

        // $task = Task::findOrFail();

        // $comments = Comment::find($id);

        // $task = Task::where('task_id', $comments->task_id)->get();

        $comments = Comment::where('id', $id)->first();

        // dd($comments->user->name);

        $task = Task::where('id', $comments->task_id)
        ->where('user_id', $comments->user_id)
        ->first();

        // // コメントが存在しない場合は処理をスキップ
        // if ($comments->isEmpty()) {
        //     abort(404);
        // }
        // コメントを削除
        $comments->delete();
     
    

    //    return redirect()->route('todo.show', compact('task', 'comment'));
    //    return redirect()->route('todo.show', compact('comments', 'task', ["id" => $task->id]));
        // return view('todo.show', compact('task', 'comments'));
        return redirect()->route('todo.show', ['id' => $task->id])->with(compact('comments', 'task'));




       

        // return redirect()->route('todo.show',compact('task','comment'));
        // return view('todo.show', compact('task','comments'));
    }
}
