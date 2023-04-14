<script {{ $attributes }} @if ($nonce) nonce="{{ $nonce }}" @endif>
    {{ $slot }}
</script>
