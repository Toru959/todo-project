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
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">詳細画面</h1>
                          </div>
                          <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <h2 class="title-font font-medium text-lg text-gray-900">{{ $task->title }}</h2>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative flex justify-center items-center">
                                  <img src={{ asset('storage/images/'.$task->file) }} alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4">
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <div class="relative">
                                  <h3 class="text-gray-500 mb-3">{{ $task->contents }}</h3>
                                </div>
                              </div>
                              <div class="p-2 w-full">
                                <a href="{{ route('todo.edit',$task->id) }}">
                                  <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集</button>
                                </a>
                              </div>  
                              <div class="p-2 w-full"> 
                                <form action="{{ route('todo.destroy', $task->id) }}" method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
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