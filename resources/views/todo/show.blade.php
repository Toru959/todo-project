<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            詳細画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto text-center items-center">
                          <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">タスク詳細</h1>
                          </div>
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                              <div class="p-2 w-full">
                              タイトル  
                                <div class="relative flex justify-center items-center">
                                  {{-- <label for="title" class="leading-7 text-sm text-gray-600">タイトル</label> --}}
                                  <h2 class="w-1/2  bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $task->title }}</h2>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative flex justify-center items-center">
                                  {{-- <label for="file" class="leading-7 text-sm text-gray-600">画像</label> --}}
                                  <img src={{ asset('storage/images/'.$task->file) }} alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4">
                                </div>
                              </div>
                              <div class="p-2 w-full">
                              内容  
                                <div class="relative">
                                  {{-- <label for="contents" class="leading-7 text-sm text-gray-600">内容</label> --}}
                                  <h3 class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $task->contents }}</h3>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                コメント一覧
                                  @foreach($comments as $comment)  
                                    <div class="relative-user">
                                      <h3>投稿者:{{ $user_name }}</h3>
                                    </div>
                                    <div class="relative-contents">
                                      <h4>コメント:{{ $contents }}</h4>
                                    </div>
                                  {{-- <label for="contents" class="leading-7 text-sm text-gray-600">コメント一覧</label> --}}
                                  {{-- <h3 class="text-gray-500 mb-3">{{ $comment->contents }}</h3> --}}
                                  @endforeach
                                </div>

                              </div>
                              <div class="p-2 w-full">
                                <a href="{{ route('todo.edit',$task->id) }}">
                                  <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集</button>
                                </a>
                              </div>  
                              <div class="p-2 w-full"> 
                                <form method="post" action="{{route('todo.destroy', $task->id)}}" id="delete_{{$task->id}}">
                                  @csrf
                                  @method('delete')
                                <td class="md:px-4 py-3">
                                  <td class="text-red-400 w-10 text-center">
                                    <button><a href="#" data-id="{{$task->id}}" onclick="deletePost(this)" class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</a></button>
                                  </td>
                                </td>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
  function deletePost(e){
    'use strict'
    if(confirm('本当に削除しても良いですか？')){
      document.getElementById('delete_'+e.dataset.id).submit();
    }
  }
</script>