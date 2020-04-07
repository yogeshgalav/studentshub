@extends('admin.app')

@section('content')
 <div class="main-panel">
        <div class="content-wrapper">
      
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Explore Page Posts</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                        <th>image</th>
                            <th>Title</th>
                             <th>Category</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php /*dd($pageSection);*/ ?>
                        @foreach($fetchTopPost as $hero) 
                            <tr>
                            <td><img src="<?php echo $hero->primary_image_path; ?>"/></td>
                                <td>{{ $hero->post_heading }}</td>
                                <td>{{ $hero->page_section }}</td>
                                <td><a href="/admin/replace_post/<?= $hero->id; ?>"><button class="btn btn-danger">Replace To</button></a></td>
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