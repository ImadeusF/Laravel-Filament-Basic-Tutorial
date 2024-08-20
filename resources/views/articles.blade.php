<x-layout>
    <x-slot:heading>
        Article Page
    </x-slot:heading>
    <h1 class="text-xl font-semibold mb-10">Voici la liste de tous les articles</h1>
    <ul class="text-2xl font-bold mb-6">
        @foreach ($articles as $article)
        <li class="border p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-4">{{ $article->title }}</h2>
            <p class="text-base text-gray-700 mb-6">Catégorie : 
                <a href="{{ route('categories.show', ['category' => $article->categories->id]) }}">
                    {{ $article->categories->name }}
                </a>
            </p>
            <p class="text-base text-gray-700 mb-6">{{ $article->content }}</p>
            <div class="flex justify-end text-sm text-gray-500">
                <span>Rédacteur : {{ $article->user->name }}</span>
                <spanc class="ml-4">Posté le : {{ $article->created_at->format('d M Y') }}</span>
                <span class="ml-4">Edité le : {{ $article->updated_at->format('d M Y') }}</span>
            </div>
        </li>
        @endforeach
    </ul>
    {{ $articles->links() }}
</x-layout>
