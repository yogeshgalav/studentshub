<div class="dropdown">
    <button class="btn btn-sm btn-default border-radius-12 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     <i class="fa fa-user"></i> {{$AuthUser->full_name}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="d-flex p-2">
                    <div class="avatar user_img_dash">
    <img src="{{$AuthUser->avatar_url ?? '/images/default-avatar.png'}}" class="avatar-img" style="width:50px;height:50px;">
</div>
                    <div class="info-post ml-2 mt-2">
                    <p class="username">{{$AuthUser->full_name}}</p>
                    </div>
            </div>
            <a href="/education-details" class="center-block ml-3 mt-1"><i class="fa fa-graduation-cap ml-2"> </i> Education Details</a>
            <div class="dropdown-divider"></div>
      <a href="/logout" class="center-block ml-3 mt-1 btn btn-sm btn-default logout_btn">Logout</a>
    </div>
  </div>