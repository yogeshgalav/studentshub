<script>
    window.App ={!! json_encode([
        'AuthUser' => $AuthUser,
        'AuthStudent' => Auth::student(),
        'AuthTeacher' => Auth::teacher(),
        'signedIn' => is_null($AuthUser),
        'csrfToken' => csrf_token(),
        'baseUrl' => URL::to('/'),
        ]) !!}
</script>