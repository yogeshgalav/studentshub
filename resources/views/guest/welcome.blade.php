@extends('guest.app')
@section('content')
<div class="container">
    
  <div class="padding_115px_top">
    <div class="row box_shadow login">
      <div class="col-md-6 pl-0 pr-0">
          <div class="login_img">
            <img
              v-lazy="'/images/Group.svg'"
              alt=""
            >
          </div>
      </div>

        <div class="col-md-6 ">
          <div class="logn_right">
            <div class="card_title">
              <h3>{{ 'Login' }}</h3>
            </div>
            <div class="card_body">
            <form
                id="login_form"
                name="login"
                method="POST"
                action="/login"
                @submit.prevent="handleSubmit"
              >
                <div class="form-group row">
                  <input
                    id="token"
                    type="hidden"
                    class="form-control"
                    name="_token"
                    :value="csrfToken"
                  >
                  <input
                    id="fcmToken"
                    type="hidden"
                    class="form-control"
                    name="fcmToken"
                    :value="fcmToken"
                  >
                </div>

                <div class="form-group">
                <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
  </div>
  <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
</div>
                </div>

                <div class="form-group">
                  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon1"><i class="fa fa-eye"></i></span>
    </div>
    <input type="text" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
  </div>
                  </div>
                  <button
                  type="submit"
                  class="btn-lg btn-primary m-0-a"
                >
                  {{ trans('Login') }}&nbsp;<i class="fa fa-arrow-right text-white" /></i>
                </button>   
</form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>  
<router-view></router-view>
@endsection