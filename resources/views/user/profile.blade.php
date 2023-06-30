@extends('layout')

@section('title', 'Profile')

@section('content')
    <x-layout>
        <div class="flex flex-col justify-center items-center w-1/3 min-w-[300px] p-10 bg-gray-200 border-2 border-gray-500">
            <div class="flex flex-col items-center">
                <h2 class="text-2xl text-center m-3">Welcome, {{ $user->name }}!</h2>
                <p>Email: {{ $user->email }}</p>
            </div>


            <div x-data="{ showInlineUrl: false }" class="flex flex-col items-center py-3">
                <p class="p-3 text-red-400">Scan the QR code to activate 2 factor authentication</p>
                <button  @click="showInlineUrl = ! showInlineUrl" class="border-gray-400 border-2 px-5 py-2 bg-gray-300 hover:text-cyan-500">
                    See QR code
                </button>
                <div x-show="showInlineUrl" class="p-4">
                    {!! $inlineUrl !!}
                </div>
            </div>
        </div>
    </x-layout>
@endsection
