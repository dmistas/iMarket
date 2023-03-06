<form action="{{ route('logout') }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="{{ $class }}">
        {{ $slot }}
    </button>
</form>
