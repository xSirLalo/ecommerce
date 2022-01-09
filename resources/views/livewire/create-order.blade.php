<div class="container grid grid-cols-5 gap-6 py-8">
    <div class="col-span-3">

        <div class="p-6 bg-white rounded-lg shadow">
            <div class="mb-4">
                <x-jet-label value="Nombre de contacto" />
                <x-jet-input type="text"
                            wire:model.defer="contact"
                            placeholder="Ingrese el nombre de la persona que recibirá el producto"
                            class="w-full" />
                <x-jet-input-error for='contact' />
            </div>

            <div>
                <x-jet-label value="Teléfono de contacto" />
                <x-jet-input type="text"
                            wire:model.defer="phone"
                            placeholder="Ingrese un número de contacto"
                            class="w-full" />
                <x-jet-input-error for='phone' />
            </div>
        </div>

        <div x-data="{ envio_type: @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg font-semibold text-gray-700">
                Envíos
            </p>

            <label class="flex items-center px-6 py-6 mb-4 bg-white rounded-lg shadow cursor-pointer">
                <input x-model="envio_type" type="radio" value="1" name="envio_type" class="text-gray-600">
                <span class="ml-2 text-gray-700">
                    Recojo en tienda ( Calle falsa 123 )
                </span>

                <span class="ml-auto font-semibold text-gray-700">
                    Gratis
                </span>
            </label>

            <div class="bg-white rounded-lg shadow">
                <label class="flex items-center px-6 py-4 cursor-pointer">
                    <input x-model="envio_type" type="radio" value="2" name="envio_type" class="text-gray-600">
                    <span class="ml-2 text-gray-700">
                        Envío a domicilio
                    </span>
                </label>

                <div class="grid-cols-2 gap-6 px-6 pb-6" :class="{ 'hidden': envio_type != 2 }">
                    {{-- Departamentos --}}
                    <div>
                        <x-jet-label value="Departamento" />

                        <select class="w-full form-control" wire:model="department_id">

                            <option value="" disabled selected>Seleccione un departamento</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for='department_id' />
                    </div>

                    {{-- Ciudades --}}
                    <div>
                        <x-jet-label value="Ciudad" />

                        <select class="w-full form-control" wire:model="city_id">

                            <option value="" disabled selected>Seleccione un ciudad</option>

                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for='city_id' />
                    </div>

                    {{-- Distritos --}}
                    <div>
                        <x-jet-label value="Distrito" />

                        <select class="w-full form-control" wire:model="district_id">

                            <option value="" disabled selected>Seleccione un distrito</option>

                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for='district_id' />
                    </div>

                    <div>
                        <x-jet-label value="Dirección" />
                        <x-jet-input class="w-full" wire:model="address" type="text" />
                        <x-jet-input-error for='address' />
                    </div>

                    <div class="col-span-2">
                        <x-jet-label value="Referencias" />
                        <x-jet-input class="w-full" wire:model="references" type="text" />
                        <x-jet-input-error for='references'/>
                    </div>
                </div>
            </div>

        </div>

        <div>
            <x-jet-button
                wire:loading.attr='disabled'
                wire:target='create_order'
                class="mt-6 mb-4" wire:click="create_order">
                Continuar con la compra
            </x-jet-button>

            <hr>

            <p class="mt-2 text-sm text-gray-700">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis, illum eius dolore suscipit quos dolorem blanditiis id, architecto sequi repellendus necessitatibus praesentium magnam velit ratione sint nostrum ea harum eos. <a href="" class="font-semibold text-orange-500">Politicas</a> </p>
        </div>

    </div>

    <div class="col-span-2">
        <div class="p-6 bg-white rounded-lg shadow">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="object-cover w-20 mr-4 h-14" src="{{ $item->options->image }}" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex">
                                <p>Cant: {{ $item->qty }}</p>
                                @isset($item->options['color'])
                                    <p class="mx-2"> - Color: {{ __($item->options['color']) }}</p>
                                @endisset
                                @isset($item->options['size'])
                                    <p>{{ $item->options['size'] }}</p>
                                @endisset
                            </div>
                            <p>USD {{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="px-4 py-6">
                        <p class="text-center text-gray-700">
                            No tiene agregado ningún item en el carrito
                        </p>
                    </li>
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">

            <div class="text-gray-700">
                <p class="flex items-center justify-between">
                    Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }} USD</span>
                </p>
                <p class="flex items-center justify-between">
                    Envio
                    <span class="font-semibold">
                        @if ($envio_type == 1 || $shipping_cost == 0)
                            Gratis
                        @else
                            {{ $shipping_cost }} USD
                        @endif

                    </span>
                </p>

                <hr class="mt-4 mb-3">

                <p class="flex items-center justify-between font-semibold">
                    <span class="text-lg">Total</span>
                    @if ($envio_type == 1)
                        {{ Cart::subtotal() }} USD
                    @else
                        {{ Cart::subtotal() + $shipping_cost }} USD
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
