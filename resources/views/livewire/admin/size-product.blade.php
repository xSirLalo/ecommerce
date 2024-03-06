<div>
    <div class="p-6 mt-12 bg-white rounded-lg shadow-lg">
        <div>
            <x-jet-label>
                Talla
            </x-jet-label>
            <x-jet-input type="text" class="w-full" placeholder="Ingrese una talla" wire:model="name" />
            <x-jet-input-error for="name" />
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

    <ul class="mt-12 space-y-4">
        @foreach ($sizes as $size)
            <li class="p-6 bg-white rounded-lg shadow-lg" wire:key="size-{{ $size->id }}">
                <div class="flex items-center">
                    <span class="text-xl font-medium">{{ $size->name }}</span>
                    <div class="ml-auto">
                        <x-jet-button wire:click="edit({{ $size->id }})" wire:loading.attr="disabled" wire:target="edit({{ $size->id }})">
                            <i class="fas fa-edit fa-fw"></i>
                        </x-jet-button>
                        <x-jet-danger-button wire:click="$emit('deleteSize', {{ $size->id }})" wire:loading.attr="disabled" wire:target="$emit('deleteSize', {{ $size->id }})">
                            <i class="fas fa-trash fa-fw"></i>
                        </x-jet-danger-button>
                    </div>
                </div>
                @livewire('admin.color-size', ['size' => $size], key('color-size-'. $size->id))
            </li>
        @endforeach
    </ul>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar talla
        </x-slot>

        <x-slot name="content">
            <x-jet-label>
                Talla
            </x-jet-label>
            <x-jet-input type="text" class="w-full" placeholder="Ingrese una talla" wire:model="name_edit" />
            <x-jet-input-error for="name_edit" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="update" wire:loading.attr="disabled" wire:target="update">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('script')
        <script>
            Livewire.on('deleteSize', sizeId => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.size-product', 'delete', sizeId);
                    }
                });
            });
        </script>
    @endpush

</div>
