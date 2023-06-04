<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ToDo一覧') }}
        </h2>
        <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('js/bookmark.js') }}"></script>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <section class="text-gray-600 body-font">
                    <form method="get" action="{{ route('todo.index') }}">
                      <input type="text" name="search" placeholder="検索"><br>
                      <button class="text-white bg-indigo-500 border-0 py-1 px-2 mt-2 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索する</button>
                    </form>
                    <div class="container px-5 pb-24 mx-auto">
                      <div class="flex flex-col text-center w-full mb-20">
                       <h1 class="text-2xl font-medium title-font mb-4 text-gray-900">ToDo一覧</h1>
                       <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Todo管理のストレスを軽減し、自由な時間を手に入れる</p>
                      </div>
                      <div class="flex flex-wrap -m-4">
                        @foreach ($tasks as $task)
                          <div class="p-4 lg:w-1/4 md:w-1/2 ">
                            <div class="h-full flex flex-col items-center text-center border border-gray-300">
                              <a href="{{ route('todo.show',$task->id) }}">
                                <img src="{{ asset('storage/images/'.$task->file) }}" alt="Image" class="aspect-w-16 aspect-h-9 w-64 h-36">
                                {{-- <img alt="team" class="flex-shrink-0 rounded-lg w-64 h-64 object-cover object-center mb-4" src="{{ asset('storage/images/'.$task->file) }}" style="object-fit: contain;"> --}}
                              </a>
                              <div class="w-full">
                                <h2 class="title-font font-medium text-lg text-gray-900">{{ $task->title }}</h2>
                                <h3 class="text-gray-500 mb-3">{{ $taskUserNames[$task->id] }}</h3>
                                <p class="mb-4">{{ $task->created_at->format('Y-m-d H:i') }}</p>
                                <span class="inline-flex"> 
                                  <button id="bookmark{{ $task->id }}" onclick="add_Bookmark('{{ $task->id }}', '{{ auth()->user()->id }}')">
                                    <i class="{{ $bookmarkInfo[$task->id] ? 'fas fa-bookmark fa-lg' : 'far fa-bookmark fa-lg' }}"></i>
                                  </button>
                                </span>
                              </div>
                              <a href="{{ route('comments.create',$task->id) }}">
                                <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg my-3">コメント</button>
                              </a>
                          </div>
                        </div>
                        @endforeach
                   </div>
                 </section>
                 {{ $tasks->links() }}
               </div>
             </div>
          </div>
    </div>
</x-app-layout>