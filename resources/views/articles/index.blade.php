<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('글 목록') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <ul>
                            @foreach($articles as $article)
                                <li class="p-3 mb-2 border rounded">
                                    <p><a class="font-bold" href="{{ route('articles.show', ['article' => $article]) }}">{{ $article->body }}</a></p>
                                    <p>{{ $article->user->name }}</p>
                                    <p>{{ $article->created_at->diffForHumans() }}</p>
                                    <div class="flex flex-row">
                                        <p class="mr-1">
                                            <a class="button rounded bg-blue-500 px-2 py-1 text-xs text-white" href="{{ route('articles.edit', ['article' => $article]) }}">수정하기</a>
                                            <form action="{{ route('articles.delete', ['article' => $article]) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="button rounded bg-red-500 px-2 py-1 text-xs text-white">삭제하기</button>
                                            </form>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
