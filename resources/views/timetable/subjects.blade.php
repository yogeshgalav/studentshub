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
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div id="firstCard" class="card">
                    <div class="card-body">
                    <form id="theForm" method="POST" action="/subjects" onsubmit="validateMyForm(event)">
                        <div class="form-group m-b-md">
                            <p>Total hours of week = {{ $total_hours }}</p>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        @for($i=0;$i<$total_subjects;$i++)
                            <div class="row form-group m-b-md">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" oninput="fillValues(event,'subject_name', {{$i}})" id="{{'subject_name_'.$i}}" name="{{'subject_name_'.$i}}" max="255">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" oninput="fillValues(event,'subject_hour', {{$i}})" id="{{'subject_hours_'.$i}}" name="{{'subject_hours_'.$i}}" min="1">
                                </div>
                            </div>
                        @endfor
                        <button type="submit" id="generate" disabled class="btn btn-primary">Generate</button>
                    </form>
                    </div>
                </div>
                <div id="secondCard" class="card">
                    <div class="card-body">
                        <table id="tablee">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        var field_values =[];
        var timetable =[];
        var working_days = {{ $working_days }};
        var subject_per_day= {{ $subject_per_day }};
        var total_subjects= {{ $total_subjects }};
        var total_hours= {{ $total_hours }};
 
        
        for(let i=0;i<total_subjects;i++){
            field_values[i]=[];
        }
        function fillValues(event,input, key){
            field_values[key][input] =input==='subject_hour'? parseInt(event.target.value) : event.target.value;
            if(!field_values.some(node=>!node.subject_name || !node.subject_hour)){
                document.getElementById("generate").disabled = false;
            }
        }
        function validateMyForm(e)
        {
            e.preventDefault();
            timetable = [...field_values];
            let cal_hours= 0;
            cal_hours = field_values.reduce((a,node)=>a+parseInt(node.subject_hour),0);

            if(cal_hours!==total_hours)
            { 
                alert("The total hours of the subject must be equal to 'Total hours for week'.");
                return false;
            }

            // document.getElementById('theForm').submit();
            // var x = document.getElementById("firstCard");
            // x.style.display = "none";

            // var y = document.getElementById("secondCard");
            // x.style.display = "block";
            var tablee = document.getElementById("tablee");
            html='';
            for(let i=0;i<working_days;i++){
                html+='<tr>';
                for(let j=0;j<subject_per_day;j++){
                    html+='<td>';
                    html+=getSubjectName();
                    html+='</td>';
                }
                html+='</tr>';
            }
            tablee.innerHTML =  html;
        }
        function getSubjectName(){
            let random_index= Math.floor((Math.random()*timetable.length));
            let random_ele = timetable[random_index];
            if(0===random_ele['subject_hour']){
                timetable.splice(random_index, 1);
                return getSubjectName();
            }
            random_ele['subject_hour']--;
            return random_ele['subject_name'];
        }
    </script>
</html>
