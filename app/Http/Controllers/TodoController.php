<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        ]);

        $file = request()->file('file')->getClientOriginalName();
        request()->file('file')->storeAs('public/images', $file);


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

        // DB上に＄idが存在しなければ404を返す。
        if (!$task) { 
            abort(404);
        }else{
            return view('todo.show', compact('task'));
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
        $task = Task::find($id);

        $task -> title = $request -> title;
        $task -> file = $request -> file;
        $task -> contents = $request -> contents;
        $task -> save();

        //追記
        return redirect()->route('todo.show', compact('task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
        public function destroy($id)
    {


        $task = Task::find($id);
        $task->delete();

        return redirect()->route('todo.index');
    }

    
}
