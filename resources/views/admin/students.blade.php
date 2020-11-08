@extends('admin.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@section('content')
 <div class="container">
        <div class="content-wrapper pt-100-px">

          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">All Students</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                            <th>Name</th>
                            <th>College</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Show Post</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        @foreach($students as $hero)
                            <tr>
                                <td rowspan="{{count($hero->batches)}}">{{  $hero->user->full_name }}</td>
                                @foreach($hero->batches as $batch)
                                 <td>{{  $batch->institute->name }}</td>
                                <td>{{  $batch->start_year }}- {{  $batch->end_year}}</td>
                                @endforeach

                                <td rowspan="{{count($hero->batches)}}"><a href="/admin/show_post/{{  $hero->id}}"><button class="btn btn-danger">Show Post</button></a></td>
                                <td rowspan="{{count($hero->batches)}}">
                           @if($hero->block_status)
                              <button type="submit" class="btn btn-success" name="submit" svalue="{{  $hero->id}}" id="unblock">unblock</button>
                                </td>
                            @else
                                <button type="submit" class="btn btn-danger" name="submit" svalue="{{  $hero->id }}" id="block">block</button>
                            @endif
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
        $("#block").click(function(){
            var blockid = $(this).attr("svalue");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               url: "{{ url('/admin/blockUpdate') }}",
              method: 'post',
              data: {
                 "_token": "{{ csrf_token() }}",
                  "id": blockid
              },
               success: function (data) {
                      alert('blocked');
                      window.location.href = "{{ url('/admin/students') }}";
               },
               error: function (data) {
                     alert(data);
               }
    });
});
        </script>
         <script>
        $("#unblock").click(function(){
            var blockid = $(this).attr("svalue");
        /* alert(blockid);*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               url: "{{ url('/admin/unblockUpdate') }}",
              method: 'post',
              data: {
                 "_token": "{{ csrf_token() }}",
                  "id": blockid
              },
               success: function (data) {
                      alert('unblocked');
                      window.location.href = "{{ url('/admin/students') }}";
               },
               error: function (data) {
                     alert(data);
               }
    });
});
        </script>
@endsection
