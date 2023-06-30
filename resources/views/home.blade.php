@extends('layout')

@section('title', 'Home')

@section('content')
    <div class="flex flex-col justify-between mx-[10%] my-[5%] bg-gray-200 border-2 border-gray-500 lg:flex-row">
        <div class="flex flex-col p-16">
            <h1 class="text-black text-4xl font-serif sm:text-7xl">MPBank</h1>
            <p class="text-black text-xl">A bank for the masses</p>
        </div>
        <div>
            <img class="object-contain max-h-[570px]"
                 src="https://res.cloudinary.com/equities-com/image/upload/v1/u/daU/eEN0df9M/hyweogzxsmbg8gh2ehqt" alt="">
        </div>

    </div>
@endsection
