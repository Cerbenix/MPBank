@extends('layout')

@section('title', 'My Accounts')

@section('content')
    <x-layout>
        <h2 class="text-3xl font-bold">My Accounts</h2>
        <div class="flex flex-col w-auto md:w-2/5">
            <x-link-button href="{{ route('accounts.create') }}">Add Account</x-link-button>
            <div class="flex flex-col p-10 bg-gray-200 border-2 border-gray-500">
                <h3 class="font-bold text-xl">Debit Accounts</h3>
                @if ($debitAccounts->isEmpty())
                    <p>No debit accounts found.</p>
                @else
                    <ul>
                        @foreach ($debitAccounts as $debitAccount)
                            <x-list-item>
                                <div class="flex flex-row justify-between items-center">
                                    <x-custom-link href="{{ route('accounts.debit', ['id' => $debitAccount->id]) }}">
                                        {{ $debitAccount->name }} -
                                        Balance: {{ $debitAccount->amount }} {{ $debitAccount->currency }}
                                    </x-custom-link>
                                    @if( $debitAccount->amount <= 0)
                                        <x-delete-button href="{{ route('accounts.delete') }}" account-id="{{ $debitAccount->id }}">
                                            Delete
                                        </x-delete-button>
                                    @endif
                                </div>
                            </x-list-item>

                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="flex flex-col p-10 bg-gray-200 border-2 border-gray-500 mt-4">
                <h3 class="font-bold text-xl">Investment Accounts</h3>
                @if ($investmentAccounts->isEmpty())
                    <p>No investment accounts found.</p>
                @else
                    <ul>
                        @foreach ($investmentAccounts as $investmentAccount)
                            <x-list-item>
                                <div class="flex flex-row justify-between items-center">
                                    <x-custom-link
                                        href="{{ route('accounts.investments', ['id' => $investmentAccount->id]) }}">

                                        {{ $investmentAccount->name }} -
                                        Balance: {{ $investmentAccount->amount }} {{ $investmentAccount->currency }}
                                    </x-custom-link>
                                        @if( $investmentAccount->amount <= 0)
                                            <x-delete-button href="{{ route('accounts.delete') }}" account-id="{{ $investmentAccount->id }}">
                                                Delete
                                            </x-delete-button>
                                        @endif
                                </div>
                            </x-list-item>

                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </x-layout>
@endsection
