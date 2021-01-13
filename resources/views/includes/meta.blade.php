<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="application-name" content="StudentsHUB"/>
<meta name="author" content="Yogesh Galav"/>
<meta name="description" content="Educational App to boost productivity of Students, Teachers and Institutes. Learn about your progress, pain points and student's field of interest."/>
<meta name="keywords" content="studenthub, studentshub, student, hub, education,knowledge,curiosity,institute information"/>
@if(isset($nocache) && $nocache)
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
@endif
@if('production' === config('app.env'))
<!-- Hotjar Tracking Code for www.studentshub.in -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2171982,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
@endif