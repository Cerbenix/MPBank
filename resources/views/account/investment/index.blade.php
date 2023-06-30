@extends('layout')

@section('title', 'Investment Account History')

@section('content')
    <x-layout>
        <h2 class="text-3xl font-bold">Investment Account: {{ $account->name }}</h2>
        <div class="w-full md:w-2/3 lg:w-1/2 xl:w-3/5">
            <x-custom-title-md>Current Investments</x-custom-title-md>
            <x-custom-table>
                <thead>
                <tr>
                    <x-custom-table-header>Name</x-custom-table-header>
                    <x-custom-table-header>Amount</x-custom-table-header>
                    <x-custom-table-header>Current Value</x-custom-table-header>
                    <x-custom-table-header>Action</x-custom-table-header>
                </tr>
                </thead>
                <tbody>
                @foreach ($investments as $investment)
                    <tr>
                        <x-custom-table-data>{{ $investment->crypto_name }}</x-custom-table-data>
                        <x-custom-table-data>{{ $investment->crypto_amount }}</x-custom-table-data>
                        <x-custom-table-data>{{ number_format($cryptoValues[$investment->crypto_id], 2) }} {{ $account->currency }}</x-custom-table-data>
                        <x-custom-table-data>
                            <a href="{{ route('sell', ['id' => $investment->id]) }}" class="border-green-500 py-0.5 px-4 border-2 bg-green-300 hover:text-red-500">Sell</a>
                        </x-custom-table-data>
                    </tr>
                @endforeach
                </tbody>
            </x-custom-table>
        </div>

        <div class="w-full md:w-2/3 lg:w-1/2 xl:w-3/5">
            <x-custom-title-md>Transfer History</x-custom-title-md>
            <x-custom-table>
                <thead>
                <tr>
                    <x-custom-table-header>Date</x-custom-table-header>
                    <x-custom-table-header>Amount</x-custom-table-header>
                    <x-custom-table-header>From/To Account</x-custom-table-header>
                    <x-custom-table-header>Description</x-custom-table-header>
                </tr>
                </thead>
                <tbody>
                @foreach ($transfers as $transfer)
                    <tr>
                        <x-custom-table-data>{{ $transfer->transfer_time }}</x-custom-table-data>
                        <x-custom-table-data>
                            @if ($transfer->sender_account_id == $account->id)
                                <span class="text-red-500">-{{ $transfer->sender_amount }} {{ $account->currency }}</span>
                            @else
                                <span class="text-green-500">+{{ $transfer->receiver_amount }} {{ $account->currency }}</span>
                            @endif
                        </x-custom-table-data>
                        <x-custom-table-data>
                            @if ($transfer->sender_account_id == $account->id)
                                {{ $transfer->receiver->user->name }} {{ $transfer->receiver->name }}
                            @else
                                {{ $transfer->sender->user->name }} {{ $transfer->sender->name }}
                            @endif
                        </x-custom-table-data>
                        <x-custom-table-data>{{ $transfer->description }}</x-custom-table-data>
                    </tr>
                @endforeach
                </tbody>
            </x-custom-table>
        </div>

        <div class="w-full md:w-2/3 lg:w-1/2 xl:w-3/5 mb-4">
        <x-custom-title-md>Investment Transaction History</x-custom-title-md>
        <x-custom-table>
            <thead>
            <tr>
                <x-custom-table-header>Date</x-custom-table-header>
                <x-custom-table-header>Transaction Type</x-custom-table-header>
                <x-custom-table-header>Crypto Name</x-custom-table-header>
                <x-custom-table-header>Crypto Amount</x-custom-table-header>
                <x-custom-table-header>Balance Change</x-custom-table-header>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <x-custom-table-data>{{ $transaction->transaction_time }}</x-custom-table-data>
                    <x-custom-table-data>{{ strtoupper($transaction->transaction_type) }}</x-custom-table-data>
                    <x-custom-table-data>{{ $transaction->crypto_name }}</x-custom-table-data>
                    <x-custom-table-data>{{ $transaction->crypto_amount }}</x-custom-table-data>
                    <x-custom-table-data>
                        @if ($transaction->transaction_type == 'sold')
                            <span class="text-green-500">+{{ $transaction->balance_change }} {{ $account->currency }}</span>
                        @else
                            <span class="text-red-500">-{{ $transaction->balance_change }} {{ $account->currency }}</span>
                        @endif
                    </x-custom-table-data>
                </tr>
            @endforeach
            </tbody>
        </x-custom-table>
        </div>
    </x-layout>
@endsection
