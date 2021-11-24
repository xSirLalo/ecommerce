<div class="container py-8">
    <section class="p-6 text-gray-700 bg-white rounded-lg shadow-lg">
        <h1 class="mb-6 text-lg font-semibold">CARRO DE COMPRAS</h1>

        @if (Cart::count())

            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cant</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Cart::content() as $item)
                        <tr>
                            <td>
                                <div class="flex">
                                    <img class="object-cover w-20 mr-4 h-15" src="{{ $item->options->image }}" alt="">
                                    <div>
                                        <p class="font-bold">{{ $item->name }}</p>
                                        @if ($item->options->color)
                                            <span>
                                                Color: {{ __($item->options->color) }}
                                            </span>
                                        @endif

                                        @if ($item->options->size)
                                            <span class="mx-1">-</span>
                                            <span>
                                                {{ $item->options->size }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span>
                                    {{ $item->price }}
                                </span>
                                <a class="ml-6 cursor-pointer hover:text-red-600" wire:click="delete('{{ $item->rowId }}')" wire:loading.class="text-red-600 opacity-25" wire:target="delete('{{ $item->rowId }}')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td>
                                <div class="flex justify-center">
                                    @if ($item->options->size)
                                        @livewire('update-cart-item-size', ['rowId' => $item->rowId], key($item->rowId))
                                    @elseif ($item->options->color)
                                        @livewire('update-cart-item-color', ['rowId' => $item->rowId], key($item->rowId))
                                    @else
                                        @livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
                                    @endif
                                </div>
                            </td>

                            <td class="text-center">
                                USD {{ $item->price * $item->qty }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a class="inline-block mt-3 text-sm cursor-pointer hover:underline" wire:click="destroy">
                <i class="fas fa-trash"></i>
                Borrar carrito de compras
            </a>
        @else
            <div class="flex flex-col items-center">
                <x-cart />
                <p class="mt-4 text-lg text-gray-700">TÚ CARRITO DE COMPRA ESTÁ VACÍO</p>

                <x-button-enlace color="orange" href="/" class="px-16 mt-4">
                    Ir al inicio
                </x-button-enlace>
            </div>
        @endif
    </section>

    @if (Cart::count())
        <div class="px-6 py-4 mt-4 bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-700">
                        <span class="text-lg font-bold">
                            Total:
                        </span>
                        USD {{ Cart::subTotal() }}
                    </p>
                </div>
                <div>
                    <x-button-enlace color="orange" href="{{ route('orders.create') }}">
                        Continuar
                    </x-button-enlace>
                </div>
            </div>
        </div>
    @endif
</div>
