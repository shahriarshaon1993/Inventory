@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-5 py-2 rounded-lg border-indigo-400 text-sm font-medium leading-5 text-indigo-700 bg-indigo-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'flex items-center px-5 py-2 rounded-lg border-transparent text-sm font-medium leading-5 text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
