@props(['product'])
<li class="bg-white rounded-lg shadow mb-4">
    <article class="flex">
        <figure>
            <img class="h-48 w-56 object-cover object-center" src="{{ $product->images->first()->url }}"
                alt="{{ $product->slug }}">
        </figure>
        <div class="flex-1 py-4 px-6 flex flex-col">
            <div class="flex justify-between">
                <div>
                    <h1 class="text-lg font-semibold text-gray-700">{{ $product->name }}</h1>
                    <p class="font-bold text-trueGray-700">USD {{ $product->price }}</p>
                </div>
                <div class="flex items-center">
                    <ul class="flex text-sm">
                        <li>
                            <i class="fa fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fa fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fa fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fa fa-star text-yellow-400 mr-1"></i>
                        </li>
                        <li>
                            <i class="fa fa-star text-yellow-400 mr-1"></i>
                        </li>
                    </ul>
                    <span class="text-gray-700 text-sm">(24)</span>
                </div>
            </div>
            <div class="mt-auto mb-6">
                <x-danger-enlace href="{{ route('products.show', $product) }}">Más informacón
                </x-danger-enlace>
            </div>
        </div>
    </article>
</li>
