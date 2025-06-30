<div class="min-w-[200px]">
    <a href="{{ route('dashboard') }}" class="h-[80px] px-3 flex items-center gap-3">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        Inventory
    </a>

    <div class="py-3 px-3">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
            Products
        </x-nav-link>
    </div>
</div>