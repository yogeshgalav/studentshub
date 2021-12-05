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
              >
                <div class="form-group row">
                  <input
                    id="token"
                    type="hidden"
                    class="form-control"
                    name="_token"
                    value="{{ csrf_token() }}"
                  >
                  <input
                    id="fcmToken"
                    type="hidden"
                    class="form-control"
                    name="fcmToken"
                  >
                </div>

                <div class="form-group">
                  <div class="mb-3">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Enter your Email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Enter your Password">
                  </div>
                </div>
                  </div>
                  <button
                  type="submit"
                  class="btn-lg btn-primary m-0-a"
                >
                  {{ 'Login' }}&nbsp;<i class="fa fa-arrow-right text-white" /></i>
                </button>   
                <div class="text-center center-col pt-2">
                  <span
                    class="text-gray"
                    style="color:#868686;"
                  >Dont't have an account?</span> <a href='/get-started'>
                    Sign Up
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
</div>
</div>
<router-view></router-view>
@endsection