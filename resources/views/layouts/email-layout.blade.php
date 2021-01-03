<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"/>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link href="{{ asset('js/app.css') }}" type="text/css" rel="stylesheet">
       <script src="{{ asset('js/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            custom: {
                "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "simple-line-icons", "Inter"], urls: ['{{ asset('fonts/inter/inter.css')}}']
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <style>
        body
        {
            background: #F5F5F5;

        }
        .logo-height-49 {
            height: 50px !important;
        }
        table
        {
            width: 100%;
            height: auto;
            border: 0;
            padding: 20px;
            overflow-x:auto;

        }
.mt-3{
    margin-top:30px;
}
.mb-3{
    margin-bottom:30px;
}
        table  tr td
        {

            border: 0;
            padding-bottom: 5px;
            vertical-align: top;

        }
        .text-center
        {
            text-align: center;
        }
        .email-template {
margin: 0;
            padding: 20px;
            background: #fff;
        }
        .text-underline {
            text-decoration :underline
        }
        .email-spacer .card-body {
            background:#fff;
            height: auto;
            padding-bottom: 20px;
        }
        .email-template .divider {
            height: 1px;
            border: 0.5px solid #BDBDBD !important;
            margin: 10px 0px 10px 0px;
        }
        .email-template .btn-primary {
            background: #10069F !important;
            text-transform:uppercase;
        }

        @media only screen and (max-width: 768px) {
        .email-template {

            padding:10px 10px 10px 10px;}
        }
        .width-40
        {
            width: 100%
        }
    </style>

</head>
<body>
<div class="container">
    <div class="email-template">
    <table>
    @if(!$theme['hide_email_logo'])
        <tr>
            <td>
                <a
                    href="/"
                    class="logo"
                >
                    <img
                        src="{{ $theme['dark_logo_url'] }}"
                        alt="{{ $theme['alt_src'] }}"
                        class="navbar-brand logo-height-49"
                    >
                </a>
            </td>
        </tr>
        <tr>
            <td> <div class="divider">&nbsp;</div></td>
        </tr>
    @endif
    @yield('content')
    </table>
    </div>
    <table>
        <tr>
            <td>
            @yield('notification_setting')
                <p class="text-center">
                    {{ __('layout.copyright-statement', ['year' => date('Y')]) }}
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>

