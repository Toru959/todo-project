<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            削除済みToDo一覧
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                      <div class="flex flex-col text-center w-full mb-20">
                       <h1 class="text-2xl font-medium title-font mb-4 text-gray-900">削除済みToDo一覧</h1>
                       <p class="lg:w-2/3 mx-auto leading-relaxed text-base"></p>
                      </div>
                      <div class="flex flex-wrap -m-4">
                        @foreach ($deletedTasks as $task)
                          <div class="p-4 lg:w-1/4 md:w-1/2 ">
                            <div class="h-full flex flex-col items-center text-center border border-gray-300">
                              <a href="{{ route('deleted-tasks.show',$task->id) }}">
                                <img alt="team" class="flex-shrink-0 rounded-lg w-full h-56 object-cover object-center mb-4" src="{{ asset('storage/images/'.$task->file) }}">
                              </a>
                              <div class="w-full">
                                <h2 class="title-font font-medium text-lg text-gray-900">{{ $task->title }}</h2>
                                <h3 class="text-gray-500 mb-3">{{ $task->user->name}}</h3>
                                <p class="mb-4">{{ $task->deleted_at->format('Y-m-d H:i') }}</p>
                                <span class="inline-flex">
                                  <a class="text-gray-500">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                    </svg>
                                  </a>
                                </span>
                              </div>
                          </div>
                        </div>
                        @endforeach
                   </div>
                 </section>
                 {{ $deletedTasks->links() }}
               </div>
             </div>
          </div>
    </div>
</x-app-layout>