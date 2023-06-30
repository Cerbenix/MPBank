@extends('layout')

@section('title', 'Money Transfer')

@section('content')
    <div class="flex justify-center mt-14" x-data="transferForm()">
        <x-custom-form action="{{ route('transfer.store') }}" method="POST">
            @csrf
            <h2 class="text-3xl font-bold">Transfer Money</h2>
            <x-input-field-container>
                <label for="sender_account_id">From Account:</label>
                <select name="sender_account_id" id="sender_account_id"
                        class="border-gray-400 border-2 px-5 py-2"
                        x-model="selectedAccount"
                        @change="updateAccountInfo"
                >
                    <option value="" selected>Select Account</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">
                            {{ $account->name }} ({{ $account->currency }})
                        </option>
                    @endforeach
                </select>
                <div class="flex flex-col border-gray-400 border-2 px-5 py-2 bg-gray-100 mt-2" x-show="selectedAccount">
                    <p x-text="'Available Balance: ' + selectedAccountAmount + ' ' + selectedAccountCurrency"></p>
                    <p x-text="'Account Type: ' + selectedAccountType"></p>
                </div>

                @error('sender_account_id')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="receiver_account">To Account:</label>
                <x-custom-input type="text" name="receiver_account" id="receiver_account" value="{{ old('receiver_account') }}"/>
                @error('receiver_account')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="amount">Amount:</label>
                <x-custom-input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}"/>
                @error('amount')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="description">Description:</label>
                <x-custom-input type="text" name="description" id="description" value="{{ old('description') }}"/>
            </x-input-field-container>

            <x-input-field-container>
                <label for="2fa_code">Authenticator Code:</label>
                <x-custom-input type="text" name="2fa_code" id="2fa_code" value="{{ old('2fa_code') }}"/>
                @error('2fa_code')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <div class="pt-3">
                <x-custom-button>Transfer</x-custom-button>
            </div>
        </x-custom-form>
    </div class="flex justify-center mt-14">

    <script>
        function transferForm() {
            return {
                selectedAccount: null,
                selectedAccountAmount: null,
                selectedAccountType: null,
                selectedAccountCurrency: null,
                updateAccountInfo() {
                    const selectedAccountData = JSON.parse(@json($accounts->keyBy('id')->toJson()));
                    const selectedAccount = selectedAccountData[this.selectedAccount];

                    if (selectedAccount) {
                        this.selectedAccountAmount = selectedAccount.amount;
                        this.selectedAccountType = selectedAccount.type.toUpperCase();
                        this.selectedAccountCurrency = selectedAccount.currency;
                    } else {
                        this.selectedAccountAmount = null;
                        this.selectedAccountType = null;
                        this.selectedAccountCurrency = null;
                    }
                }
            };
        }
    </script>
@endsection
