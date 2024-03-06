<div>
    <div class="p-6 my-12 bg-white rounded-lg shadow-lg">
        {{-- Color --}}
        <di class="mb-6">
            <x-jet-label>
                Color
            </x-jet-label>
            <div class="grid grid-cols-6 gap-6">
                @foreach ($colors as $color)
                    <label>
                        <input type="radio" name="color_id" value="{{ $color->id }}" wire:model.defer="color_id">
                        <span class="ml-2 text-gray-700 capitalize">{{ __($color->name) }}</span>
                    </label>
                @endforeach
            </div>
            <x-jet-input-error for="color_id" />
        </di>
        {{-- Cantidad --}}
        <div>
            <x-jet-label>
                Cantidad
            </x-jet-label>
            <x-jet-input type="number" class="w-full" placeholder="Ingrese una cantidad" wire:model.defer="quantity" />
            <x-jet-input-error for="quantity" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-action-message class="mr-3" on="saved">
                Agregado
            </x-jet-action-message>
            <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save">
                Agregar
            </x-jet-button>
        </div>
    </div>

    @if ($product_colors->count())
        <div class="p-6 bg-white rounded-lg shadow-lg">
            <table>
                <thead>
                    <th class="w-1/3 px-4 py-2">Color</th>
                    <th class="w-1/3 px-4 py-2">Cantidad</th>
                    <th class="w-1/3 px-4 py-2"></th>
                </thead>
                <tbody>
                    @foreach ($product_colors as $product_color)
                        <tr wire:key="product_color-{{ $product_color->pivot->id }}">
                            {{-- <td class="px-4 py-2 capitalize">{{ $colors->where('id', $product_color->pivot->color_id)->first()->name }}</td> --}}
                            <td class="px-4 py-2 capitalize">{{ __($colors->find($product_color->pivot->color_id)->name) }}
                            </td>
                            <td class="px-4 py-2">{{ $product_color->pivot->quantity }} unidades</td>
                            <td class="flex px-4 py-2">
                                <x-jet-secondary-button class="ml-auto mr-2"
                                    wire:click="edit({{ $product_color->pivot->id }})" wire:loading.attr="disabled"
                                    wire:target="edit({{ $product_color->pivot->id }})">
                                    Actualizar
                                </x-jet-secondary-button>
                                <x-jet-danger-button wire:click="$emit('deletePivot', '{{ $product_color->pivot->id }}')">
                                    Eliminar
                                </x-jet-danger-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar colores
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label>
                    Color
                </x-jet-label>

                <select class="w-full form-control" wire:model="pivot_color_id">
                    <option value="">Seleccione un color</option>
                    @foreach ($colors as $color)
                        <option class="capitalize" value="{{ $color->id }}">{{ __($color->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-jet-label>
                    Cantidad
                </x-jet-label>
                <x-jet-input type="number" class="w-full" placeholder="Ingrese una cantidad"
                    wire:model.defer="pivot_quantity" />
                <x-jet-input-error for="quantity" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)" wire:loading.attr="disabled" wire:target="open">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-button wire:click="update" wire:loading.attr="disabled" wire:target="update">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
    @push('script')
        <script>
            Livewire.on('deletePivot', pivot => {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emit('delete', pivot);

                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            })
        </script>
    @endpush
</div>
