<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <div class="flex justify-between mt-2">
        <div>
            <h1>Products</h1>
        </div>
        <div class="mt-8 text-2xl font-medium text-gray-900">
            <div class="mr-2">
                <x-button wire:click="confirmProductAdd()" wire:loading.attr="disabled" >
                    {{ __('Add new product') }}
                </x-button>
            </div>
        </div>
    </div>

    <p class="mt-6 text-gray-500 leading-relaxed">
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.500ms="q" type="search" placehodler="Search" class="w-full border rounded py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" >
            </div>
            <div class="mr-2">
                <input type="checkbox" class="mr-2 leading-tight" wire:model="active" > Active Only?
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-2 py-2 w-20">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')" >ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-2 py-2 w-70">
                        <div class="flex items-center">
                            <button wire:click="sortBy('product_name')" >Product Name</button>
                            <x-sort-icon sortField="product_name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-2 py-2 w-28">
                        <div class="flex items-center">
                            <button wire:click="sortBy('price')" >Price</button>
                            <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-2 py-2 w-40">
                        <button wire:click="sortBy('status')" >Status</button>
                        <x-sort-icon sortField="status" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                    <th class="px-2 py-2 w-48">
                        Action
                    </th>
                    <th class="px-2 py-2 w-60">
                        <button wire:click="sortBy('created_at')" >Date Created</button>
                        <x-sort-icon sortField="created_at" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="border px-4 py-2"> {{ $product->id }} </td>
                        <td class="border px-4 py-2"> {{ $product->product_name }} </td>
                        <td class="border px-4 py-2"> {{ number_format( $product->price, 2 ) }} </td>
                        <td class="border px-4 py-2"> {{ $product->status ? 'Active' : 'Not active' }} </td>
                        <td class="border px-4 py-2">
                            <button class="bg-green-600 text-white px-2 py-1">Edit</button>
                            <x-danger-button wire:click="confirmProductDeletion({{ $product->id }})" wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-danger-button>

                        </td>
                        <td class="border px-4 py-2"> {{ $product->created_at }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </p>
    <p class="mt-4">
        {{ $products->links() }}
    </p>

    <p>
        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingProductDeletion">
            <x-slot name="title">
                {{ __('Delete Product') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this product? ') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('confirmingProductDeletion',  false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteProduct( {{ $confirmingProductDeletion }} )" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </p>

    <p>
        <!-- Add a new product Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingProductAdd">
            <x-slot name="title">
                {{ __('Add Product') }}
            </x-slot>

            <x-slot name="content">
                    <!-- Product Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="product_name" value="{{ __('Product Name') }}" />
                        <x-input id="product_name" type="text" class="mt-1 block w-full" wire:model.defer="product.product_name" />
                        <x-input-error for="product.product_name" class="mt-2" />
                    </div>

                    <!-- Product Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="price" value="{{ __('Price') }}" />
                        <x-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="product.price" />
                        <x-input-error for="product.price" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="status" value="{{ __('Status') }}" />
                        <x-checkbox id="status" type="checkbox" class="mt-1" wire:model.defer="product.status" />
                        <x-input-error for="product.status" class="mt-2" />
                    </div>

            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('confirmingProductAdd',  false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="createProduct()" wire:loading.attr="disabled">
                    {{ __('Add Product') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </p>

</div>
