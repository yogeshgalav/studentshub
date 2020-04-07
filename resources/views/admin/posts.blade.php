@extends('admin.app')

@section('content')
 <div class="main-panel">
        <div class="content-wrapper">
      
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">All Posts</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                            <th>Title</th>
                             
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        @foreach($posts as $hero) 
                            <tr>
                                <td>{{ $hero->post_heading }}</td>
                                <td><a href="/admin/show_details_post/<?= $hero->id; ?>"><button class="btn btn-danger">Show Post</button></a></td>
                                <!-- <td><a href="#"><button class="btn btn-danger">Block</button></a></td> -->
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
@endsection