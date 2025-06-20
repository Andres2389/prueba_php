<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>Rick & Morty Characters</title>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Rick & Morty Characters</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($characters->isEmpty())
        <form action="{{ route('import') }}" method="POST">
            @csrf
            <button class="bg-green-500 text-white px-4 py-2 rounded mb-5">
                Importar y Guardar en Base de Datos
            </button>
        </form>
    @endif
    

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($characters as $character)
            <div class="bg-white rounded shadow p-4" x-data="{ open: false }">
                <img src="{{ $character->image }}" alt="{{ $character->name }}" class="w-full h-48 object-cover rounded mb-3">
                <h2 class="text-xl font-semibold">{{ $character->name }}</h2>
                <p><strong>ID:</strong> {{ $character->api_id }}</p>
                <p><strong>Status:</strong> {{ $character->status }}</p>
                <p><strong>Species:</strong> {{ $character->species }}</p>

                <div class="flex justify-between mt-4">
                    <button @click="open = true" class="bg-blue-500 text-white px-4 py-2 rounded">Detalle</button>
                    <a href="{{ url('/admin/characters/' . $character->id . '/edit') }}" class="bg-green-500 text-white px-4 py-2 rounded">Editar</a>
                </div>

                <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" style="display: none;">
                    <div class="bg-white p-6 rounded-lg w-96 relative">
                        <button @click="open = false" class="absolute top-2 right-2 text-gray-600 text-xl">&times;</button>
                        <img src="{{ $character->image }}" alt="{{ $character->name }}" class="w-full h-48 object-cover rounded mb-3">
                        <h2 class="text-xl font-bold mb-2">{{ $character->name }}</h2>
                        <p><strong>Type:</strong> {{ $character->type ?: 'N/A' }}</p>
                        <p><strong>Gender:</strong> {{ $character->gender }}</p>
                        <p><strong>Origin Name:</strong> {{ $character->origin_name }}</p>
                        <p><strong>Origin URL:</strong>
                            @if($character->origin_url)
                                <a href="{{ $character->origin_url }}" target="_blank" class="text-blue-500 underline">Ver</a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
