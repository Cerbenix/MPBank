@extends('layout')

@section('title', 'Create Account')

@section('content')
    <x-layout>
        <x-custom-form action="{{ route('accounts.store') }}" method="post">
            @csrf
            <h2 class="text-3xl font-bold">Create Account</h2>
            <x-input-field-container>
                <label for="type">Account Type:</label>
                <x-custom-select name="type" id="type" >
                    <option value="debit">Debit Account</option>
                    <option value="investment">Investment Account</option>
                </x-custom-select>
                @error('type')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="currency">Currency:</label>
                <x-custom-select name="currency" id="currency">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency }}">{{ $currency }}</option>
                    @endforeach
                </x-custom-select>
                @error('currency')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="amount">Initial Amount:</label>
                <x-custom-input type="text" name="amount" id="amount"/>
                @error('amount')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <div class="pt-3">
                <x-custom-button>Create Account</x-custom-button>
            </div>
        </x-custom-form>
    </x-layout>

@endsection
