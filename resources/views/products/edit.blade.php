<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Products
                </a>

                <div class="flex items-center">
                    <x-icon.chevron-right class="w-5 h-5 text-gray-400" />
                    <a class="ml-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Edit
                    </a>
                </div>
            </li>
        </ol>

        <div class="flex pr-2">
            <x-primary-button-link href="{{ route('products.create') }}">
                Create
            </x-primary-button-link>
        </div>
    </nav>

    <div class="overflow-auto">
        <x-alert-message />

        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Update product
                        </h2>
                    </header>

                    <form method="post" action="{{ route('products.update', $product->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" autofocus autocomplete="name" placeholder="Write product name"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="purchase_price" value="Purchase price" />
                            <x-text-input id="purchase_price" name="purchase_price" type="text" class="mt-1 block w-full" :value="old('purchase_price', $product->purchase_price)" autocomplete="purchase_price" placeholder="Write purchase price"/>
                            <x-input-error class="mt-2" :messages="$errors->get('purchase_price')" />
                        </div>

                        <div>
                            <x-input-label for="sell_price" value="Sell price" />
                            <x-text-input id="sell_price" name="sell_price" type="text" class="mt-1 block w-full" :value="old('sell_price', $product->sell_price)" autocomplete="sell_price" placeholder="Write sell price"/>
                            <x-input-error class="mt-2" :messages="$errors->get('sell_price')" />
                        </div>

                        <div>
                            <x-input-label for="opening_stock" value="Opening stock" />
                            <x-text-input id="opening_stock" name="opening_stock" type="number" min="1" class="mt-1 block w-full" :value="old('opening_stock', $product->opening_stock)" autocomplete="opening_stock" placeholder="Write opening stock"/>
                            <x-input-error class="mt-2" :messages="$errors->get('opening_stock')" />
                        </div>

                        <div>
                            <x-input-label for="current_stock" value="Current stock" />
                            <x-text-input id="current_stock" name="current_stock" type="number" min="1" class="mt-1 block w-full" :value="old('current_stock', $product->current_stock)" autocomplete="current_stock" placeholder="Write current stock"/>
                            <x-input-error class="mt-2" :messages="$errors->get('current_stock')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
