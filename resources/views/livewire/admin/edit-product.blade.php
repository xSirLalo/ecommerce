<div class="max-w-4xl px-4 py-12 mx-auto text-gray-700 sm:px-6 lg:px-8">
    <h1 class="mb-8 text-3xl font-semibold text-center">Complete esta información para crear un producto</h1>

    <div class="mb-4" wire:ignore>
        <form action="{{ route('admin.products.files', $product) }}" method="POST" class="dropzone" id="my-great-dropzone">
        </form>
    </div>

    @if ($product->images->count())
        <section class="bg-white shadow-xl rounded p-6 mb-4">
            <h1 class="text-2xl text-center font-semibold mb-2">Imágenes del producto</h1>
            <ul class="flex flex-wrap">
                @foreach ($product->images as $image)
                    <li class="relative" wire:key="image-{{ $image->id }}">
                        <img class="w-32 h-20 object-cover" src="{{ $image->url }}" alt="{{ $product->name }}">
                        <x-jet-danger-button class="absolute top-2 right-2"
                            wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                            wire:targe="deleteImage({{ $image->id }})">
                            x
                        </x-jet-danger-button>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <div class="p-6 bg-white rounded-lg shadow-xl">
        <div class="grid grid-cols-2 gap-6 mb-4">
            {{-- Categoría --}}
            <div>
                <x-jet-label value="Categorías" />
                <select name="w-full form-control" wire:model="category_id">
                    <option value="" selected disabled>Seleccione una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="category_id" />
            </div>
            {{-- Subcategoría --}}
            <div>
                <x-jet-label value="Subcategorías" />
                <select name="w-full form-control" wire:model="product.subcategory_id">
                    <option value="" selected disabled>Seleccione una subcategoría</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="product.subcategory_id" />
            </div>
        </div>
        {{-- Nombre --}}
        <div class="mb-4">
            <x-jet-label value="Nombre del producto" />
            <x-jet-input type="text" class="w-full" wire:model="product.name" />
            <x-jet-input-error for="product.name" />
        </div>
        {{-- Slug --}}
        <div class="mb-4">
            <x-jet-label value="Slug del producto" />
            <x-jet-input type="text" class="w-full bg-gray-200" wire:model="slug" />
            <x-jet-input-error for="slug" />
        </div>
        {{-- Descripción --}}
        <div class="mb-4">
            <div wire:ignore>
                <x-jet-label value="Descripción del producto" />
                <textarea class="w-full form-control" rows="4" wire:model="product.description" x-data x-init="ClassicEditor.create($refs.miEditor).then(function(editor) { editor.model.document.on('change:data', () => { @this.set('product.description', editor.getData()) }) }).catch(error => { console.error(error); });"
                    x-ref="miEditor"></textarea>
            </div>
            <x-jet-input-error for="product.description" />
        </div>
        <div class="grid grid-cols-2 gap-6 mb-4">
            {{-- Marca --}}
            <div>
                <x-jet-label value="Marca del producto" />
                <select name="w-full form-control" wire:model="product.brand_id">
                    <option value="" selected disabled>Seleccione una marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="product.brand_id" />
            </div>
            {{-- Precio --}}
            <div>
                <x-jet-label value="Precio del producto" />
                <x-jet-input type="number" class="w-full" wire:model="product.price" step=".01" />
                <x-jet-input-error for="product.price" />
            </div>
        </div>

        @if ($this->subcategory)
            @if (!$this->subcategory->color && !$this->subcategory->size)
                {{-- Cantidad --}}
                <div>
                    <x-jet-label value="Cantidad de productos" />
                    <x-jet-input type="number" class="w-full" wire:model="product.quantity" />
                    <x-jet-input-error for="product.quantity" />
                </div>
            @endif
        @endif
        <div class="flex items-center justify-end mt-4">
            <x-jet-action-message class="mr-3" on="saved">
                Actualizado
            </x-jet-action-message>
            <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save">
                Actualizar producto
            </x-jet-button>
        </div>
    </div>

    @if ($this->subcategory)
        @if ($this->subcategory->size)
            @livewire('admin.size-product', ['product' => $product], key('size-product-' . $product->id))
        @elseif ($this->subcategory->color)
            @livewire('admin.color-product', ['product' => $product], key('color-product-' . $product->id))
        @endif
    @endif

    @push('script')
        <script>
            // Dropzone.autoDiscover = false;
            // document.addEventListener('livewire:load', function() {
            //     let dropzone = new Dropzone('#my-great-dropzone', {
            //         url: "{{ route('admin.products.files', $product) }}",
            //         addRemoveLinks: true,
            //         dictRemoveFile: "Eliminar archivo",
            //         dictDefaultMessage: "Arrastra aquí tus archivos",
            //         maxFilesize: 2,
            //         acceptedFiles: "image/*",
            //         headers: {
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //         },
            //         init: function() {
            //             this.on('error', function(file, response) {
            //                 if (file.size > 2 * 1024 * 1024) {
            //                     this.removeFile(file);
            //                     Livewire.emit('errorSize', 'El archivo no puede ser mayor a 2MB');
            //                 }
            //             });
            //             this.on('success', function(file, response) {
            //                 Livewire.emit('fileUpload', response);
            //             });
            //         }
            //     });
            // });

            Dropzone.autoDiscover = false;
            document.addEventListener('livewire:load', function() {
                let dropzone = new Dropzone('#my-great-dropzone', {
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dictDefaultMessage: "Arrastra aquí tus archivos",
                    acceptedFiles: "image/*",
                    paramName: "file", // The name that will be used to transfer the file
                    maxFilesize: 2, // MB
                    init: function() {
                        this.on('error', function(file, response) {
                            if (file.size > 2 * 1024 * 1024) {
                                this.removeFile(file);
                                Livewire.emit('errorSize', 'El archivo no puede ser mayor a 2MB');
                            }
                        });
                    },
                    complete: function(file) {
                        this.removeFile(file);
                    },
                    queuecomplete: function() {
                        Livewire.emit('fileUploadRefresh');
                    }
                });
            });

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

                        Livewire.emitTo('admin.color-product', 'delete', pivot);

                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
            })

            Livewire.on('deleteColorSize', pivot => {
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

                        Livewire.emitTo('admin.color-size', 'delete', pivot);

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
