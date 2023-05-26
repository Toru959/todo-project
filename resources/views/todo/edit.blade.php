<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('todo.update', ['id'=>$task->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-col text-center w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">TASK編集</h1>
                                {{-- <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify.</p> --}}
                            </div>
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                    <label for="title" class="leading-7 text-sm text-gray-600">タイトル</label>
                                    <input type="title" id="title" name="title" value="{{ $task->title }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="flex flex-wrap -m-2">
                                    <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="file" class="leading-7 text-sm text-gray-600">画像</label>
                                        <div class="p-2 w-full">
                                            <img src={{ asset('storage/images/'.$task->file) }} alt="team" class="flex-shrink-0 rounded-lg w-48 h-48 object-cover object-center sm:mb-0 mb-4">
                                        </div>
                                        <div class="p-2 w-full">
                                            <input type="file" id="file" name="file" value="" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="p-2 w-1/2">
                                    <div class="relative">
                                    <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                    <input type="email" id="email" name="email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div> --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                    <label for="contents" class="leading-7 text-sm text-gray-600">変更内容</label>
                                    <textarea id="contents" name="contents" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $task->contents }}</textarea>
                                </div>
                                </div> 
                                    <div class="p-2 w-full">
                                        <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                                        <button class="text-white bg-gray-500 border-0 py-2 px-8 focus:outline-none hover:bg-gray-600 rounded text-lg">戻る</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </section>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>