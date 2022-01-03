<template>
  <div class="dropdown">
    <button
      id="headerProfileDropdown"
      class="btn btn-sm border-radius-12 dropdown-toggle"
      type="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
      style="height: 50px;display: flex;align-items: center;"
    >
      <profile-image
        :avatar="AuthUser.avatar_url"
        :user-name="AuthUse.full_name"
        size="small"
      />
    </button>
    <div
      class="dropdown-menu"
      aria-labelledby="dropdownMenuButton"
    >
      <div class="d-flex p-2">
        <div class="avatar user_img_dash">
          <profile-image
            :avatar="AuthUser.avatar_url"
            :user-name="AuthUse.full_name"
          />
        </div>
        <div class="info-post ml-2 mt-2">
          <p class="username">
            {{ AuthUser.full_name }}
          </p>
        </div>
      </div>
      <div class="dropdown-divider" />
      <p>
        <a
          href="/account-settings"
          class="center-block ml-3 mt-1 text-black-50"
        >Account Settings</a>
      </p>
      <div class="dropdown-divider" />
      <p>
        <a
          href="/contactus"
          class="center-block ml-3 mt-1 text-black-50"
        >Contactus</a>
      </p>
      <p>
        <a
          href="/faq"
          class="center-block ml-3 mt-1 text-black-50"
        >FAQ</a>
      </p>
      <p>
        <a
          href="/feedback"
          class="center-block ml-3 mt-1 text-black-50"
        >Feedback</a>
      </p>
      <div class="dropdown-divider" />
      <div>
        <a
          href="/logout"
          class="center-block mt-1 btn btn-sm btn-default logout_btn"
          style="margin: 0 auto; width:50%;display: block;"
        >Logout</a>
      </div>
    </div>
  </div>
</template>