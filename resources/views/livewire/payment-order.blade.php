<div>

    {{-- @php
        // SDK de Mercado Pago
        require base_path('/vendor/autoload.php');
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));
        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

        $shipments = new MercadoPago\Shipments();

        $shipments->cost = $order->shipping_cost;
        $shipments->mode = 'not_specified';

        $preference->shipments = $shipments;

        // Crea un ítem en la preferencia
        foreach ($items as $product) {
            $item = new MercadoPago\Item();
            $item->title = $product->name;
            $item->quantity = $product->qty;
            $item->unit_price = $product->price;

            $products[] = $item;
        }
        //...
        $preference->back_urls = [
            'success' => route('orders.pay', $order),
            'failure' => 'http://www.tu-sitio/failure',
            'pending' => 'http://www.tu-sitio/pending',
        ];
        $preference->auto_return = 'approved';
        // ...
        $preference->items = $products;
        $preference->save();
    @endphp --}}

    <div class="container grid grid-cols-5 gap-6 py-8">
        <div class="col-span-3">
            <div class="px-6 py-4 mb-6 bg-white rounded-lg shadow-lg">
                <p class="text-gray-700 uppercase"><span class="font-semibold">Número de orden:</span> Order-{{ $order->id }}</p>
            </div>
            <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                <div class="grid grid-cols-2 gap-6 text-gray-700">
                    <div>
                        <p class="text-lg font-semibold uppercase">Envio</p>
                        @if ($order->envio_type == 1)
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
                                                @isset($item->options->color)
                                                    Color: {{ __($item->options->color) }}
                                                @endisset
                                                @isset($item->options->size)
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
        </div>
        <div class="col-span-2">
            <div class="px-6 pt-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between mb-4">
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
                        {{-- <div class="cho-container">
                        </div> --}}
                    </div>
                </div>
                <div id="paypal-button-container"></div>
            </div>
        </div>
    </div>

    {{-- SDKMercadoPago.jsV2 --}}
    {{-- <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        // Agrega credenciales de SDK
        const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
            locale: 'es-MX'
        });

        // Inicializa el checkout
        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '.cho-container', // Indica el nombre de la clase donde se mostrará el botón de pago
                label: 'Pagar', // Cambia el texto del botón de pago (opcional)
            }
        });
    </script> --}}

    @push('script')
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}"></script>

        <script>
            paypal.Buttons({

                // Sets up the transaction when a payment button is clicked
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '{{ $order->total }}' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                            }
                        }]
                    });
                },

                // Finalize the transaction after payer approval
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        // Successful capture! For dev/demo purposes:
                        // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        // var transaction = orderData.purchase_units[0].payments.captures[0];
                        // alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                        Livewire.emit('payOrder');
                        // When ready to go live, remove the alert and show a success message within this page. For example:
                        // var element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '';
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                    });
                }
            }).render('#paypal-button-container');
        </script>
    @endpush
</div>
