<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <div class="flex justify-between mt-2">
        <div>
            <h1>Create New Product</h1>
        </div>
        <div class="mt-8 text-2xl font-medium text-gray-900">
            <div class="mr-2">
                <x-button wire:click="confirmProductAdd" >
                    <a href="{{ route('products') }}">All Products</a>
                </x-button>
            </div>
        </div>
    </div>

    <p class="mt-6 text-gray-500 leading-relaxed w-20">
        <form wire:submit.prevent="create_product">
            @csrf

            <!-- Product Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="product_name" value="{{ __('Product Name') }}" />
                <x-input id="product_name" type="text" class="mt-1 block w-full" wire:model.defer="product.product_name" />
                <x-input-error for="product.product_name" class="mt-2" />
            </div>



            <!-- Product Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="product_price" value="{{ __('Price') }}" />
                <x-input id="product_price" type="text" class="mt-1 block w-full" wire:model.defer="product.price" />
                <x-input-error for="product.price" class="mt-2" />
            </div>

            <!-- Status -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="product_status" value="{{ __('Status') }}" />
                <x-checkbox id="product_status" type="checkbox" class="mt-1" wire:model.defer="product.status" />
                <x-input-error for="product.status" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="product_description" value="{{ __('Description') }}" />
                <textarea class="mt-1 block w-full border-gray-400" name="product_description" id="" cols="30" rows="10"></textarea>
                <x-input-error for="product_description" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-action-message class="mr-3" on="created">
                    {{ __('Created.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:click="createProduct()">
                    {{ __('Create Product') }}
                </x-button>
            </div>

        </form>
    </p>
</div>
