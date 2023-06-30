<div {{ $attributes->merge(['class' => "flex flex-col items-center mt-14 " . $attributes->get('class')]) }}>
   {{ $slot }}
</div>
