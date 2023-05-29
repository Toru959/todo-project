<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tasks=Task::latest()->paginate(8);
        // $user = User::all();

        // dd($user);
        
        return view('todo.index',['tasks' => $tasks]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:258',
            'contents' => 'required|string|max:1000',
            //fileは必須　追加
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = request()->file('file')->getClientOriginalName();
        request()->file('file')->storeAs('public/images', $file);

        // $imageFile = $request->file;
        // if(!is_null($imageFile) && $imageFile->isValid()){
        //     Storage::putFile('public/images', $imageFile);
        // }



        // 画像が添付されている場合
        // $imagePath = 'storage/public/images/'.$imageFile;

        // 画像が添付されていない場合
        // $imagePath = null;

        $todo = new Task;
        $todo -> title = $request -> title;
        $todo -> file = $file;
        $todo -> contents = $request -> contents;
        $todo -> user_id = Auth::id();

        $todo -> save();

        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $task = Task::find($id);

        $comments = Comment::find($id);
        $user_name = $comments->user->name;
        $contents = $comments->contents;

        // dd($comments);
        // return view('todo.show', compact('comments'));
        // dd($task);
        if (!$task) { 
            abort(404);
        }else{
            return view('todo.show', compact('task','comments', 'user_name', 'contents'));
        }

    
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd(Task::find($id));
        $task = Task::find($id);

        if (!$task) { 
            abort(404);
        }else{
            return view('todo.edit', compact('task'));
        }

        //追記
        return redirect()->route('todo.index');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:258',
            'contents' => 'required|string|max:1000',
            // fileは必須　追加
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = request()->file('file')->getClientOriginalName();
        request()->file('file')->storeAs('public/images', $file);

        // 画像なしでも処理は通るが、一覧ページの画像の表示がおかしい。要修正
        // if(!is_null($request->file)){
        //     $file = request()->file('file')->getClientOriginalName();
        //     request()->file('file')->storeAs('public/images', $file);
        // }else{
        //     $file = null;
        // }

        $task = Task::find($id);

        $task -> title = $request -> title;
        $task -> file = $file;
        $task -> contents = $request -> contents;
        $task -> save();

        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
    public function destroy($id)
    {
        $task = Task::findOrFail($id)->delete(); // ソフトデリート処理

        return redirect()->route('todo.index');
    }

    public function deletedTasksIndex()
    {
        $deletedTasks = Task::onlyTrashed()->paginate(8);
        return view('deleted-tasks', compact('deletedTasks'));
    }

    public function deletedTasksShow($id)
    {
        $deletedTasks = Task::onlyTrashed()->findOrFail($id);
        return view('deleted-task-show', compact('deletedTasks'));
    }

    public function deletedTasksDestroy($id)
    {
        Task::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('deleted-tasks.index');
    }

    public function deletedTasksRestore($id)
    {
        $restoredRecord = Task::withTrashed()->findOrFail($id);
        $restoredRecord->restore();

        return redirect()->route('deleted-tasks.index');
    }
    
}
