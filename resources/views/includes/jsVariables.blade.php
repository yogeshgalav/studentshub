<script>
    window.App ={!! json_encode([
        'AuthUser' => $AuthUser,
        'AuthUserType' => $AuthUserType,
        'signedIn' => is_null($AuthUser),
        'csrfToken' => csrf_token(),
        'baseUrl' => URL::to('/'),
        ]) !!}
</script>