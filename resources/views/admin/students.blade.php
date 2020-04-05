@extends('admin.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@section('content')
 <div class="main-panel">
        <div class="content-wrapper">
      
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
                            <th>Branch</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Show Post</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  // dd($students); ?>
                        @foreach($students as $hero) 
                            <tr>
                                <td>{{ $hero['user']->full_name }}</td>
                                  
                                  @foreach($hero->institutes as $rol)
                                 <td>{{$rol->name }}</td>
                                   @endforeach
                              
                              @foreach($hero->branches as $rol)
                                 <td>{{$rol->branch_name }}</td>
                                   @endforeach
                          
                            @foreach($hero->courses as $rol)
                                 <td>{{$rol->course_name }}</td>
                                   @endforeach
                                
                                @foreach($hero->batches as $rol)
                                 <td>{{ $rol->start_year }}-{{ $rol->end_year }}</td>
                                   @endforeach
                               
                                <td><a href="show_post/<?= $hero['id'];?>"><button class="btn btn-danger">Show Post</button></a></td>
                                <td>
                           <?php if($hero['block_status']){ ?>
                              <button type="submit" class="btn btn-success" name="submit" svalue="<?= $hero['id']; ?>" id="unblock">unblock</button>
                                </td>
                              <?php  }
                                else
                                { ?>
                                <button type="submit" class="btn btn-danger" name="submit" svalue="<?= $hero['id']; ?>" id="block">block</button>
                               <?php } ?>
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
           /*alert(blockid);*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               url: "{{ url('/blockUpdate') }}",
              method: 'post',
              data: { 
                 "_token": "{{ csrf_token() }}",
                  "id": blockid 
              },
               success: function (data) {
                      alert('blocked');    
                      window.location.href = "{{ url('/students') }}";     
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
               url: "{{ url('/unblockUpdate') }}",
              method: 'post',
              data: { 
                 "_token": "{{ csrf_token() }}",
                  "id": blockid 
              },
               success: function (data) {
                      alert('unblocked'); 
                      window.location.href = "{{ url('/students') }}";            
               },
               error: function (data) {
                     alert(data);
               }
    });
});
        </script>
@endsection