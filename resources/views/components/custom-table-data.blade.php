<td {{ $attributes->merge(['class' => "py-2 px-4 border-b "  . $attributes->get('class')]) }}>
    {{ $slot }}
</td>
