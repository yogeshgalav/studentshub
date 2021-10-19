<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Timetable</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                    <form method="POST" action="/timetable">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group m-b-md">
                            <label for="working_days">No. of Working Days</label>
                            <input type="number" class="form-control" id="working_days" name="working_days" aria-describedby="working_days" min="1" max="7">
                        </div>
                        <div class="form-group m-b-md">
                            <label for="subject_per_day">No. of Subjects per Day</label>
                            <input type="number" class="form-control" id="subject_per_day" name="subject_per_day" aria-describedby="subject_per_day" min="1" max="9">
                        </div>
                        <div class="form-group m-b-md">
                            <label for="total_subjects">Total Subjects</label>
                            <input type="number" class="form-control" id="total_subjects" name="total_subjects" aria-describedby="total_subjects" min="1">
                        </div>
                        <div class="form-group m-b-md">
                            <p>Total hours for week = No of Working days * No of Subjects per day</p>
                            <strong id="total_hours"></strong>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        var first = document.getElementById('working_days');
        var second = document.getElementById('subject_per_day');
        var result = document.getElementById('total_hours');

        first.addEventListener("input", sum);
        second.addEventListener("input", sum);

        function sum() {
            var one = parseFloat(first.value) || 1;
            var two = parseFloat(second.value) || 1;
            var total_hours = one*two;
            result.innerHTML =  '= '+ total_hours;
        }
    </script>
</html>
