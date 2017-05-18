<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // Will fill the Laraval object with {csfrToken: xxx}
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
        
</script>