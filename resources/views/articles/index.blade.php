<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('본문') }}
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
                                    <a class="font-bold" href="#">{{ $article->body }}</a>
                                    <span class="block">{{ $article->created_at->diffForHumans() }}</span>
                                    <span>{{ $article->user->name }}</span>
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
