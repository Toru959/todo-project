<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            削除済みタスク詳細画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto text-center items-center">
                          <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">削除済みタスク詳細画面</h1>
                          </div>
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                            {{-- @foreach ($deletedTasks as $task) --}}
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <h2 class="title-font font-medium text-lg text-gray-900">{{ $deletedTasks->title }}</h2>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative flex justify-center items-center">
                                  <img src={{ asset('storage/images/'.$deletedTasks->file) }} alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4">
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <h3 class="text-gray-500 mb-3">{{ $deletedTasks->contents }}</h3>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <a href="{{ route('deleted-tasks.restore',$deletedTasks->id) }}">
                                  <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">復元</button>
                                </a>
                              </div>  
                              <div class="p-2 w-full"> 
                                <form method="post" action="{{route('deleted-tasks.destroy', $deletedTasks->id)}}" id="delete_{{$deletedTasks->id}}">
                                  @csrf
                                  @method('delete')
                                <td class="md:px-4 py-3">
                                  <td class="text-red-400 w-10 text-center">
                                    <button><a href="#" data-id="{{$deletedTasks->id}}" onclick="deletePost(this)" class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">完全に削除</a></button>
                                  </td>
                                </td>
                                </form>
                              </div>
                            {{-- @endforeach --}}
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