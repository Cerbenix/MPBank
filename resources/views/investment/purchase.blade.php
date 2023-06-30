@extends('layout')

@section('title', 'Investment Purchase')

@section('content')
    <div class="flex justify-center mt-24" x-data="purchaseForm()">

        <x-custom-form action="{{ route('purchase.store') }}" method="POST">
            @csrf
            <h2 class="text-3xl font-bold">Investment Purchase</h2>

            <x-input-field-container>
                <p>Crypto: {{ $crypto->getName() }}</p>
                <p>Symbol: {{ $crypto->getSymbol() }}</p>
                <p>Price in USD: ${{ number_format($crypto->getPrice(), 3) }}</p>
            </x-input-field-container>

            <x-input-field-container>
                <label for="account_id">Investment Account:</label>
                <select name="account_id" id="account_id" x-model="selectedAccount" @change="updateBalance()"
                        class="border-gray-400 border-2 px-5 py-2">
                    <option>Select Account</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">
                            {{ $account->name }} ({{ $account->currency }})
                        </option>
                    @endforeach
                </select>
                <div class="flex flex-col border-gray-400 border-2 px-5 py-2 bg-gray-100 mt-2" x-show="accountBalance">
                    <p x-text="'Available Balance: ' + accountBalance + ' ' + selectedAccountCurrency"></p>
                </div>

                @error('account_id')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="crypto_amount">Crypto Amount:</label>
                <input type="text" name="crypto_amount" id="crypto_amount" x-model="cryptoAmount"
                       @input="calculateTotalPurchasePrice()" class="border-gray-400 border-2 px-5 py-2">
                <div x-show="totalPurchasePrice"
                     class="flex flex-col border-gray-400 border-2 px-5 py-2 bg-gray-100 mt-2">
                    <p x-text="totalPurchasePrice"></p>
                </div>
                @error('crypto_amount')
                <x-error>{{ $message }}</x-error>
                @enderror
                @error('total_price')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="2fa_code">Authenticator Code:</label>
                <x-custom-input type="text" name="2fa_code" id="2fa_code" value="{{ old('2fa_code') }}" class="tracking-[5px]"/>
                @error('2fa_code')
                <x-error>{{ $message }}</x-error>
                @enderror
            </x-input-field-container>

            <input type="hidden" name="crypto_id" id="crypto_id" value="{{ $crypto->getId() }}">
            <div>
                <x-custom-button>Buy</x-custom-button>
            </div>
        </x-custom-form>
    </div>

    <script>
        function purchaseForm() {
            return {
                selectedAccount: null,
                accountBalance: null,
                selectedAccountCurrency: null,
                cryptoAmount: null,
                totalPurchasePrice: null,
                updateBalance() {
                    const selectedAccountData = JSON.parse(@json($accounts->keyBy('id')->toJson()));
                    const selectedAccount = selectedAccountData[this.selectedAccount];

                    if (selectedAccount) {
                        this.accountBalance = selectedAccount.amount;
                        this.selectedAccountCurrency = selectedAccount.currency;
                        this.calculateTotalPurchasePrice();
                    } else {
                        this.accountBalance = null;
                        this.selectedAccountCurrency = null;
                        this.totalPurchasePrice = null;
                    }
                },
                calculateTotalPurchasePrice() {
                    if (this.selectedAccount && this.cryptoAmount) {
                        const selectedAccountData = JSON.parse(@json($accounts->keyBy('id')->toJson()));
                        const selectedAccount = selectedAccountData[this.selectedAccount];
                        const conversionRates = @json($conversionRate);
                        const selectedRate = conversionRates[this.selectedAccount];
                        const priceInAccountCurrency = selectedRate * this.cryptoAmount * {{ $crypto->getPrice() }};
                        this.totalPurchasePrice = `Total Purchase Price: ${priceInAccountCurrency.toFixed(2)} ${selectedAccount.currency}`;
                    } else {
                        this.totalPurchasePrice = null;
                    }
                }
            };
        }
    </script>
@endsection
