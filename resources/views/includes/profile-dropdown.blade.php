<div class="dropdown">
    <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     <profile-image avatar="{{$AuthUser->avatar_url}}" user-name="{{$AuthUser->full_name}}" size="small" />
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="d-flex p-2">
                    <div class="avatar user_img_dash">
    <profile-image avatar="{{$AuthUser->avatar_url}}" user-name="{{$AuthUser->full_name}}"/>
</div>
                    <div class="info-post ml-2 mt-2">
                    <p class="username">{{$AuthUser->full_name}}</p>
                    </div>
            </div>
            <p><a href="/education-details" class="center-block ml-3 mt-1">Education Details</a></p>
            <p><a href="/contactus" class="center-block ml-3 mt-1">Contactus</a></p>
            <p><a href="/faq" class="center-block ml-3 mt-1">FAQ</a></p>
            <p><a href="/feedback" class="center-block ml-3 mt-1">Feedback</a></p>
            <div class="dropdown-divider"></div>
      <a href="/logout" class="center-block ml-3 mt-1 btn btn-sm btn-default logout_btn">Logout</a>
    </div>
  </div>
