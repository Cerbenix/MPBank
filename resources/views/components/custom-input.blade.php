<input type="{{$type}}" name="{{$name}}" id="{{ $id }}" value="{{$value}}"
       placeholder="{{ $placeholder }}" {{ $attributes->merge(['class' => "border-gray-400 border-2 px-5 py-2 " . $attributes->get('class')]) }}>
