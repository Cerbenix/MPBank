@extends('layout')

@section('title', 'Debit Account History')

@section('content')
    <x-layout>
        <h2 class="text-3xl font-bold">Debit Account {{ $account->name }}</h2>
        <div class="flex flex-col w-full md:w-2/3 lg:w-1/2 xl:w-3/5">
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
                                <span class="text-red-500">-{{ $transfer->sender_amount }}</span>
                            @else
                                <span class="text-green-500">+{{ $transfer->receiver_amount }}</span>
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
    </x-layout>
@endsection

