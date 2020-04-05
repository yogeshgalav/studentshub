@extends('admin.app')

@section('content')
 <div class="main-panel">
        <div class="content-wrapper">
      
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Post Details</p>
                  <div class="table-responsive">                        
                        @foreach($posts as $user)
                        <div style="float: left;">
                        <h2 style="line-height:3;">{{ $user->post_heading }}</h2>
                        <img src="{{ $user->primary_image_path }}" class="img img-responsive"/>
                       </div>
                        @endforeach
                        <div style="float:left!important;margin-left:20px;margin-top:6em;">
                        <h4>Likes </h4>  {{ $like }}
                        <h4>Dislike </h4> {{ $disLike }}
                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection