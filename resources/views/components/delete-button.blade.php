<form method="POST" action="{{ $href }}">
    @csrf
    @method('DELETE')
    <input type="hidden" name="account_id" value="{{ $accountId }}">

    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this account?')">
        {{ $slot }}
    </button>
</form>
