@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Gerenciar Slides</h1>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Upload Form -->
        <div class="mb-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Adicionar Novo Slide</h2>
            <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Imagem do Slide
                    </label>
                    <input type="file"
                           name="image"
                           accept="image/*"
                           required
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Formatos aceitos: JPG, PNG, GIF, WEBP. Tamanho máximo: 2MB</p>
                </div>

                <div>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium">
                        Adicionar Slide
                    </button>
                </div>
            </form>
        </div>

        <!-- Slides List -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Slides Existentes ({{ count($slides) }})</h2>

            @if(count($slides) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($slides as $slide)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-video bg-gray-100">
                                <img src="{{ asset($slide['path']) }}"
                                     alt="{{ $slide['name'] }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <p class="font-medium text-gray-900 truncate mb-1" title="{{ $slide['name'] }}">
                                    {{ $slide['name'] }}
                                </p>
                                <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                                    <span>{{ $slide['size'] }}</span>
                                    <span>{{ $slide['modified'] }}</span>
                                </div>
                                <form action="{{ route('admin.slides.destroy', $slide['name']) }}"
                                      method="POST"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este slide?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum slide encontrado</h3>
                    <p class="mt-1 text-sm text-gray-500">Comece adicionando seu primeiro slide usando o formulário acima.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

