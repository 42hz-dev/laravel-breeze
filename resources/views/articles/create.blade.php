<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('글쓰기') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.post') }}" method="post">
                        @csrf
                        <label for="title">내용</label>
                        <input type="text" id="body" name="body" class="block w-full mb-2 rounded" value="{{ old('body') }}">
                        @error('body')
                        <div class="text-xs text-red-600 mb-2">{{ $message }}</div>
                        @enderror
                        <button class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
