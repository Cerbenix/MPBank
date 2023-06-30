@extends('layout')

@section('title', 'Register')

@section('content')
    <x-layout>
        <x-custom-form method="POST" action="{{ route('register') }}">
            @csrf
            <h2 class="text-3xl font-bold">Register</h2>
            <x-input-field-container>
                <label for="name">Name:</label>
                <x-custom-input type="text" id="name" name="name" value="{{ old('name') }}"/>
                @error('name')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

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
                <label for="password_confirmation">Confirm Password:</label>
                <x-custom-input type="password" id="password_confirmation" name="password_confirmation"/>
                @error('password_confirmation')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <div class="pt-3">
                <x-custom-button>Register</x-custom-button>
            </div>
        </x-custom-form>
    </x-layout>
@endsection

