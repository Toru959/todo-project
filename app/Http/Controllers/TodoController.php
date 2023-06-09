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
    //クロージャーでミドルウェア設定。edit、update、deleteにのみ適用され、
    //指定されたIDのタスクの所有者と現在のログインユーザーが一致しない場合にのみアクセスを制限する。showには誰でも行ける。
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('id'); 
            if (!is_null($id)) {
                $task = Task::findOrFail($id);
                $userId = $task->user->id;
                $ownerId = Auth::id();
                if ($userId !== $ownerId) {
                    abort(404);
                }
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 通常の表示と検索されたタスクの表示
        $search = $request->search;
        $query = Task::with('User')->search($search);

        $tasks = $query->paginate(8);

        $taskUserNames = [];
        foreach ($tasks as $task) {
            $taskUserNames[$task->id] = $task->User->name;
        }
        // ブックマーク情報を取得し、ビューに渡す
        $bookmarkInfo = $this->getBookmarkInfo($tasks);
        return view('todo.index', compact('tasks', 'taskUserNames','bookmarkInfo'));
    }

    private function getBookmarkInfo($tasks)
    {
       $bookmarkInfo = [];

       // 現在のユーザーのIDを取得
       $userId = Auth::id();

    foreach ($tasks as $task) {
        // ブックマークが存在するかどうかを確認し、結果を配列に格納
        $isBookmarked = $task->bookmarks()->where('user_id', $userId)->exists();
        $bookmarkInfo[$task->id] = $isBookmarked;
    }

    return $bookmarkInfo;
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
            'title' => 'required|string|max:30',
            'contents' => 'required|string|max:140',
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

        // $comments = Comment::find($id);
        $comments = Comment::where('task_id', $id)->get();

        // dd($comments);
        // return view('todo.show', compact('comments'));
        // dd($task);
        if (!$task) { 
            abort(404);
        }else{
            return view('todo.show', compact('task','comments'));
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
            'title' => 'required|string|max:30',
            'contents' => 'required|string|max:140',
            // fileは必須　追加
            // 'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        
        $task = Task::find($id);

        // dd($request->title, $request->contents);

        if(!$task) {
            abort(404);
        }
        if ($request->hasFile('file')) { //画像がアップロードありの処理
            $file = $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/images', $file);
            $task->title = $request->title;
            $task->contents = $request->contents;
            $task->file = $file;

            $task->save();
        }else{ //画像のアップロードなしの処理
            $task->title = $request->title;
            $task->contents = $request->contents;

            $task->save();
        }
            
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
