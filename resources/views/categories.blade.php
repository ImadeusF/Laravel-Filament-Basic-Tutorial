<x-layout>
    <x-slot:heading>
        Categories Page
    </x-slot:heading>
    <h1 class="text-xl font-semibold mb-10">Voici la liste de tous les catégories</h1>
    <ul class="text-2xl font-bold mb-6">
        @foreach ($categories as $category)
        <li class="border p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-4">{{ $category->name }}</h2>
            <div class="flex justify-end text-sm text-gray-500">
                <span>Posté le : {{ $category->created_at->format('d M Y') }}</span>
                <span class="ml-4">Edité le : {{ $category->updated_at->format('d M Y') }}</span>
            </div>
        </li>
        @endforeach
    </ul>
    {{ $categories->links() }}
</x-layout>