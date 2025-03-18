@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-b-2 border-green-600 text-sm font-semibold leading-5 text-green-800 dark:text-green-300 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 dark:text-gray-300 hover:text-green-700 dark:hover:text-green-400 hover:border-green-300 dark:hover:border-green-700 focus:outline-none focus:text-green-700 dark:focus:text-green-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
