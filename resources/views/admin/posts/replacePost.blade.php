@extends('admin.app')

@section('content')
 <div class="container">
        <div class="content-wrapper pt-100-px">
      
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Replace with any Posts</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                            <th>Title</th>
                            
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php {{ $current_post_id; }}?>
                        @foreach($fetchTopPost as $hero) 
                            <tr>
                                <td>{{ $hero->post_heading }}</td>
                                <td><a href="/admin/new_post_id/<?= $hero->id; ?>/old_post_id/<?= $current_post_id; ?>"><button class="btn btn-success">Replace with</button></a></td>
                                <!-- <td><a href="#"><button class="btn btn-danger">Block</button></a></td> -->
                            </tr>
                          @endforeach 
                      </tbody>
                    </table>
                    {{ $fetchTopPost->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection