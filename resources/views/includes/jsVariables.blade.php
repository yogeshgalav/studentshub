<script>
    this.$page.props ={!! json_encode([
        'AuthUser' => $AuthUser,
        'AuthStudent' => Auth::student(),
        'AuthTeacher' => Auth::teacher(),
        'signedIn' => is_null($AuthUser),
        'csrfToken' => csrf_token(),
        'baseUrl' => URL::to('/'),
        'mode' => config('app.env'),
        'vapidPublicKey' => config('webpush.vapid.public_key'),
            'pusher' => [
                'key' => config('broadcasting.connections.pusher.key'),
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            ],
        ]) !!};
</script>