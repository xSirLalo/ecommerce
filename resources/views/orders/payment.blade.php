<x-app-layout>

    <div class="container py-8">
        <div class="px-6 py-4 mb-6 bg-white rounded-lg shadow-lg">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de orden:</span> Order-{{ $order->id }}</p>
        </div>

        <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="text-lg font-semibold uppercase">Envio</p>
                    @if ($order->env)
                        <p class="text-sm">Los productos deben ser recogidos en tienda</p>
                        <p class="text-sm">Calle falsa 123</p>
                    @else
                        <p class="text-sm">Los productos serán enviados a:</p>
                        <p class="text-sm">{{ $order->address }}</p>
                        <p>{{ $order->department->name }} - {{ $order->city->name }} - {{ $order->district->name }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-lg font-semibold uppercase">Datos de contacto</p>
                    <p class="text-sm">Persona que recibirá el producto {{ $order->contact }}</p>
                    <p class="text-sm">Teléfono de contacto {{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 mb-6 text-gray-700 bg-white rounded-lg shadow-lg">
            <p class="mb-4 text-xl font-semibold">Resumen</p>

            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <div class="flex">
                                    <img class="object-cover w-20 mr-4 h-15" src="{{ $item->options->image }}" alt="">
                                    <article>
                                        <h1 class="font-bold">{{ $item->name }}</h1>
                                        <div class="flex text-sm">
                                            @isset ($item->options->color)
                                               Color: {{ __($item->options->color) }}
                                            @endisset

                                            @isset ($item->options->size)
                                                - {{ $item->options->size }}
                                            @endisset
                                        </div>
                                    </article>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $item->price }} USD
                            </td>
                            <td class="text-center">
                                {{ $item->qty }}
                            </td>
                            <td class="text-center">
                                {{ $item->price * $item->qty }} USD
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between p-6 bg-white rounded-lg shadow-lg">
            <img class="h-8" src="{{ asset('img/MC_VI_DI_2-1.png') }}" alt="">
            <div class="text-gray-700">
                <p class="text-sm font-semibold">
                    Subtotal: {{ $order->total - $order->shipping_cost }} USD
                </p>
                <p class="text-sm font-semibold">
                    Envio: {{ $order->shipping_cost }} USD
                </p>
                <p class="text-lg font-semibold">
                    Total: {{ $order->total }} USD
                </p>
            </div>
        </div>
    </div>

</x-app-layout>
