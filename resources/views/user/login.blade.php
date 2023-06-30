@extends('layout')

@section('title', 'Login')

@section('content')
    <x-layout>
        <x-custom-form method="POST" action="{{ route('login') }}">
            @csrf
            <h2 class="text-3xl font-bold">Login</h2>
            <x-input-field-container>
                <label for="email">Email:</label>
                <x-custom-input type="text" id="email" name="email" value="{{ old('email') }}"/>
                @error('email')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="password">Password:</label>
                <x-custom-input type="password" id="password" name="password"/>
                @error('password')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="two_factor_code">Authenticator Code:</label>
                <x-custom-input type="text" id="two_factor_code" name="two_factor_code" class="tracking-[5px]"/>
                @error('two_factor_code')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <div class="pt-3">
                <x-custom-button>Login</x-custom-button>
            </div>
        </x-custom-form>
    </x-layout>
@endsection



