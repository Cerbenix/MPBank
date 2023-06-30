<button {{ $attributes->merge(['class' => "border-gray-400 border-2 px-5 py-2 bg-gray-300 hover:text-cyan-500 " . $attributes->get('class')]) }}>
    {{ $slot }}
</button>
