<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bookmark一覧') }}
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
                    <div class="container px-5 py-24 mx-auto">
                      <div class="flex flex-col text-center w-full mb-20">
                       <h1 class="text-2xl font-medium title-font mb-4 text-gray-900">Bookmark一覧</h1>
                          {{-- <p class="lg:w-2/3 mx-auto leading-relaxed text-base">タスク管理のストレスを軽減し、自由な時間を手に入れる</p>  --}}
                          </div>
                          <div class="flex flex-wrap -m-4">
                          @foreach ($bookmarks as $bookmark)
                             <div id="task{{ $bookmark->id }}" class="p-4 lg:w-1/4 md:w-1/2 ">
                               <div class="h-full flex flex-col items-center text-center border border-gray-300">
                                 <a href="{{ route('todo.show',$bookmark->task->id) }}">
                                   <img alt="team" class="flex-shrink-0 rounded-lg w-full h-56 object-cover object-center mb-4" src="{{ asset('storage/images/'.$bookmark->task->file) }}">
                                 </a>
                               <div class="w-full">
                                 <h2 class="title-font font-medium text-lg text-gray-900">{{ $bookmark->task->title }}</h2>
                                 <h3 class="text-gray-500 mb-3">{{ $bookmark->task->user->name}}</h3>
                                 <p class="mb-4">{{ $bookmark->created_at->format('Y-m-d H:i') }}</p>
                                 <span class="inline-flex"> 
                                    <button id="bookmark2{{ $bookmark->id }}" onclick="destroy_Bookmark('{{ $bookmark->id }}')">
                                        <i class="fas fa-bookmark fa-lg"></i>
                                    </button>
                                  </span>
                               </div>
                            </div>
                          </div>
                        @endforeach
                   </div>
                 </section>
                 {{ $bookmarks->links() }}
               </div>
             </div>
          </div>
    </div>
</x-app-layout>