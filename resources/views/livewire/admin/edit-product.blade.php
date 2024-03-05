<div class="max-w-4xl px-4 py-12 mx-auto text-gray-700 sm:px-6 lg:px-8">
    <h1 class="mb-8 text-3xl font-semibold text-center">Complete esta información para crear un producto</h1>
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
</div>
