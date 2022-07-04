<template>
  <section class="row">
    <Head>
      <title>{{ institute ? institute.name : "My Institute" }}</title>
    </Head>
    <!-- Header -->
    <div
      v-if="institute"
      id="institute_header"
      class="col-md-12"
    >
      <div
        class="card"
      >
        <div class="card-body p-4">
          <div class="">
            <img
              v-if="institute.avatar_url"
              :src="institute.avatar_url"
              alt=""
            >
            <img
              v-else-if="institute_banner_url"
              :src="institute_banner_url"
              alt=""
            >
            <img
              v-else
              src="/images/banner.png"
              style="
                                width: 100%;
                                height: 185px;
                                margin-bottom: -40px;
                                border-radius: 15px;
                            "
              alt=""
            >
            <file-upload
              id="documentUpload"
              ref="upload"
              class="EditBanner btn btn-light bottom-right"
              post-action="/upload/post"
              extensions="jpg,jpeg,png"
              accept="image/*"
              :drop="true"
              :size="102 * 1024 * 10"
              @input="inputUpdate"
            >
              <img
                src="/images/cam-icon.svg"
                alt=""
              >
              edit banner image
            </file-upload>
          </div>
          <div class="container">
            <img
              v-if="institute.avatar_url"
              :src="institute.avatar_url"
              alt=""
            >
            <img
              v-else-if="logo_url"
              :src="logo_url"
              alt=""
            >
            <img
              v-else
              class="institute-avatar"
              src="/images/default-institute.png"
              alt="Student Hub"
              width="120 "
              height="120"
              style="
                                margin-left: 15px;
                                border-radius: 100px;
                                border-color: white;
                            "
            ><file-upload
              id="documentUpload"
              ref="upload"
              class="edit-avatar bottom-left"
              post-action="/upload/post"
              extensions="jpg,jpeg,png"
              accept="image/*"
              :drop="true"
              :size="1024 * 1024 * 10"
              @input="inputUpdate"
            >
              <img
                src="/images/cam-icon.svg"
                alt=""
              >
            </file-upload>
          </div>
          <h3 style="margin: 20px 0px 0px 20px">
            {{ institute ? institute.name : "My Institute" }}
            <button
              v-if="editPermission"
              type="button"
              class="btn btn-link"
              data-toggle="modal"
              data-target="#addEditInstituteModal"
            >
              <i
                class="fas fa-pencil-alt text-grey"
                style="color: white"
              />
            </button>
          </h3>
          
      
          <p style="margin-left: 20px">
            {{ institute.description }}
          </p>
          <div>
            <div style="float: right">
              <ul class="social-network social-circle">
                <li>
                  <a
                    target="_blank"
                    :href="
                      institute.fb_url
                        ? institute.fb_url
                        : '#'
                    "
                    :disabled="
                      institute.fb_url ? false : true
                    "
                    :class="[
                      'icoFacebook',
                      institute.fb_url ? '' : 'disabled',
                    ]"
                    title="Facebook"
                  ><i
                    class="fab fa-facebook-f"
                  /></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="
                      institute.twitter_url
                        ? institute.twitter_url
                        : '#'
                    "
                    :disabled="
                      institute.twitter_url ? false : true
                    "
                    :class="[
                      icoTwitter,
                      institute.twitter_url
                        ? ''
                        : 'disabled',
                    ]"
                    title="Twitter"
                  ><i
                    class="fab fa-twitter"
                  /></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="
                      institute.insta_url
                        ? institute.insta_url
                        : '#'
                    "
                    :disabled="
                      institute.insta_url ? false : true
                    "
                    :class="[
                      icoInstagram,
                      institute.insta_url
                        ? ''
                        : 'disabled',
                    ]"
                    title="Instagram"
                  ><i
                    class="fab fa-instagram"
                  /></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    :href="
                      institute.linkedin_url
                        ? institute.linkedin_url
                        : '#'
                    "
                    :disabled="
                      institute.linkedin_url
                        ? false
                        : true
                    "
                    :class="[
                      icoLinkedin,
                      institute.linkedin_url
                        ? ''
                        : 'disabled',
                    ]"
                    title="Linkedin"
                  ><i
                    class="fab fa-linkedin"
                  /></a>
                </li>
                <li>
                  <a
                    :href="
                      institute.youtube_vedio_url
                        ? institute.youtube_vedio_url
                        : '#'
                    "
                    :disabled="
                      institute.youtube_vedio_url
                        ? false
                        : true
                    "
                    :class="[
                      icoYoutube,
                      institute.youtube_vedio_url
                        ? ''
                        : 'disabled',
                    ]"
                    target="_blank"
                    title="Youtube"
                  ><i
                    class="fab fa-youtube"
                  /></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <modal
        id="addEditInstituteModal"
        key="addEditInstituteModal"
        ref="addEditInstituteModal"
        name="addEditInstituteModal"
        class="model-md"
        heading="Profile Info"
        @submit="saveProfile()"
      >
        <template slot="modalBody">
          <form validationScope="add_institute_form">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label
                    for="fb_url"
                  >Facebook Profile Url</label>
                  <input
                    v-model="
                      institute.fb_url
                    "
                    class="form-control"
                    type="text"
                    placeholder="http://facebook.com/profile-id"
                    @input="dataUpdated"
                  >
                  <span
                    class="text-danger"
                  >{{
                    errors.fb_url
                  }}</span>
                  <label>Twitter Url</label>
                  <input
                    v-model="
                      institute.twitter_url
                    "
                    class="form-control"
                    type="text"
                    placeholder="http://twitter.com/profile-id"
                    @input="dataUpdated"
                  ><span
                    class="text-danger"
                  >{{
                    errors.twitter_url
                  }}</span>
                  <label>Instagram
                    Username</label>
                  <input
                    v-model="
                      institute.insta_url
                    "
                    class="form-control"
                    type="text"
                    placeholder="http://instagram.com/profile-id"
                    @input="dataUpdated"
                  ><span
                    class="text-danger"
                  >{{
                    errors.insta_url
                  }}</span>
                  <label>Linkedin Profile
                    Url</label>
                  <input
                    v-model="
                      institute.linkedin_url
                    "
                    class="form-control"
                    type="text"
                    placeholder="http://linked.com/profile-id"
                    @input="dataUpdated"
                  ><span
                    class="text-danger"
                  >{{
                    errors.linkedin_url
                  }}</span>
                  <label>Youtube Vedio
                    Url</label>
                  <input
                    v-model="
                      institute.youtube_vedio_url
                    "
                    class="form-control"
                    type="text"
                    placeholder="http://youtube.com/profile-id"
                    @input="dataUpdated"
                  ><span
                    class="text-danger"
                  >{{
                    errors.youtube_vedio_url
                  }}</span>
                  <label
                    for="website"
                  >Website</label>
                  <input
                    id="website"
                    v-model="
                      institute.website
                    "
                    name="website"
                    class="form-control"
                    placeholder="write website Name here"
                    @input="dataUpdated"
                  >
                  <label
                    for="address"
                  >Address</label>
                  <input
                    id="address"
                    v-model="
                      institute.address
                    "
                    name="address"
                    class="form-control"
                    placeholder="write Address here"
                    @input="dataUpdated"
                  >
                  <label
                    for="city"
                  >City</label>
                  <input
                    id="city"
                    v-model="
                      institute.city
                    "
                    name="city"
                    class="form-control"
                    placeholder="write City here"
                    @input="dataUpdated"
                  >
                  <label
                    for="state"
                  >State</label>
                  <input
                    id="state"
                    v-model="
                      institute.state
                    "
                    name="state"
                    class="form-control"
                    placeholder="write State here"
                    @input="dataUpdated"
                  >
                </div>
              </div>
            </div>
          </form>
        </template>
      </modal>
    </div>

    <div
      v-if="!AuthUser.preferred_institute_id"
      class="col-md-12"
    >
      <div class="row">
        <div class="col-md-8 col-12">
          <p class="text-blue weight-600 mb-2 mt-3">
            Enter your preferred institute name to see Teachers and
            Students.
          </p>
          <select-institute v-model="selected_institute" />
        </div>
        <div class="col-md-8 col-12">
          <button
            v-if="isCourseValid"
            type="button"
            class="btn btn-md btn-primary mt-1"
            @click="submitCourse"
          >
            Submit
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="AuthUser.preferred_institute_id"
      class="col-md-12 mt-3"
    >
      <nav-tabs
        :tabs="tabs"
        :initial-tab="initialTab"
      >
        <template slot="tab-heading-teachers">
          {{ "Teachers" }}
        </template>
        <template slot="tab-panel-teachers">
          <div class="col-md-3 col-12 mb-2 mt-2">
            <social-sharing
              :url="
                AuthUser.full_name +
                  ' has invited you to join ' +
                  institute.name +
                  ' on Students Hub. click the link below to join now \n ' +
                  baseUrl +
                  '/get-started?inId=' +
                  institute.id
              "
              inline-template
            >
              <div class="">
                <network network="whatsapp">
                  <button
                    type="button"
                    class="btn btn-success btn-lg"
                  >
                    <i
                      class="fab fa-whatsapp"
                    />&nbsp;&nbsp;Invite
                  </button>
                </network>
              </div>
            </social-sharing>
          </div>
          <div
            v-if="!teachers.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <div class="card-body">
                  <p>
                    Invite your teachers to join
                    StudentsHub..
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-8 col-12">
              <div
                v-for="(teacher, index) in teachers"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div
                          style="
                                                        text-align: -webkit-center;
                                                    "
                        >
                          <profile-image
                            :user-name="
                              teacher.full_name
                            "
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p
                        class="mb-0 font-weight-bold text-black"
                      >
                        <a
                          :href="
                            '/profile/' + teacher.id
                          "
                        >
                          {{ teacher.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{
                          teacher.preferred_course
                            ? teacher
                              .preferred_course
                              .course_name
                            : ""
                        }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-students">
          {{ "Students" }}
        </template>
        <template slot="tab-panel-students">
          <div class="col-md-3 col-12 mb-2 mt-2">
            <social-sharing
              :url="
                AuthUser.full_name +
                  ' has invited you to join ' +
                  institute.name +
                  ' on Students Hub. click the link below to join now \n ' +
                  baseUrl +
                  '/get-started?inId=' +
                  institute.id
              "
              inline-template
            >
              <div class="">
                <network network="whatsapp">
                  <button
                    type="button"
                    class="btn btn-success btn-lg"
                  >
                    <i
                      class="fab fa-whatsapp"
                    />&nbsp;&nbsp;Invite
                  </button>
                </network>
              </div>
            </social-sharing>
          </div>
          <div
            v-if="!students.length"
            class="row"
          >
            <div class="col-md-10">
              <div class="card">
                <div class="card-body">
                  <p>
                    Invite your friends to join Student's
                    Hub.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="row"
          >
            <div class="col-md-8 col-12">
              <div
                v-for="(student, index) in students"
                :key="index"
                class="card mb-2"
              >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                        <div
                          style="
                                                        text-align: -webkit-center;
                                                    "
                        >
                          <profile-image
                            :user-name="
                              student.full_name
                            "
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <p
                        class="mb-0 font-weight-bold text-black"
                      >
                        <a
                          :href="
                            '/profile/' + student.id
                          "
                        >
                          {{ student.full_name }}</a>
                      </p>
                      <span class="font-weight-normal">
                        {{
                          student.preferred_course
                            ? student
                              .preferred_course
                              .course_name
                            : ""
                        }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template slot="tab-heading-about">
          {{ "About" }}
        </template>
        <template slot="tab-panel-about">
          <div id="about-html">
            <div class="col-md-10">
              <div v-if="editPermission">
                <p v-if="instituteVerified===false">
                  thanks! Your account is created. <br>
                  Our team will soon contact you on phone for
                  account verification.<br>
                  Once account verified you will be able to
                  promote your institute to thousands of
                  students.
                </p>
              </div>
<<<<<<< Updated upstream:resources/js/Pages/common/my-institute.vue
              <Accordion
=======
           <Accordion
>>>>>>> Stashed changes:resources/js/Pages/institute/show-institute.vue
                v-if="instituteVerified===true"
                title="Blog"
              >
                <div
                  v-if="editPermission"
                  class="edit-btn-row"
                >
                  <button
                    v-if="isEdit"
                    type="button"
                    class="btn btn-primary"
                    @click="editAdmiDetails()"
                  >
                    <i
                      class="fas fa-pencil-alt"
                      style="color: white"
                    />
                    Edit
                  </button>
                  <button
                    v-else
                    type="button"
                    class="btn btn-primary"
                    @click="submitblog"
                  >
                    Save
                  </button>
                </div>
                <rich-text-editor
                  v-if="!isEdit"
                  id="ArticleEditor"
                  v-model="new_blog"
                />
              </Accordion>
              <Accordion
                v-if="instituteVerified===true"
                title="Administrators"
              >
                <div
                  v-if="editPermission"
                  class="edit-btn-row"
                >
                  <button
                    v-if="isEdit"
                    type="button"
                    class="btn btn-primary"
                    @click="editAdmiDetails()"
                  >
                    <i
                      class="fas fa-pencil-alt"
                      style="color: white"
                    />
                    Edit
                  </button>
                  <button
                    v-else
                    type="button"
                    class="btn btn-primary"
                    @click="saveAdmiDetails()"
                  >
                    Save
                  </button>
                </div>
                <div class="card-body">
                  <div v-if="institute_users.length">
                    <div
                      class=" row d-inline-flex align-items-center justify-content-center"
                      style="gap: 40px;"
                    >
                      <div
                        v-for="(
                          instituteuser, index
                        ) in institute_users"
                        :key="index"
                        class="Administrator-profile"
                      >
                        <div>
                          <img
                          class="intitute-avatar"
                            src="/images/default-avatar.png"
                            alt="Student Hub"
                            width="120"
                            height="120"
                            style="
                                                            border-radius: 50%;
                                                        "
                          >
                        </div>
    
   
                        <div style="font-size: 15px; font-weight:800">
                          {{
                            instituteuser.user_name
                          }}
                        </div>
                        <div style="font-size: 15px; font-weight:500">
                          {{
                            instituteuser.role
                          }}
                        </div>
                        <div style="height: 30px;">
                          <button
                            v-if="editPermission"
                            class="btn btn-primary"
                            type="button"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="Delete"
                            @click="
                              deleteInstituteUser(
                                instituteuser
                              )
                            "
                          >
                            <i class="fa fa-trash" />
                          </button>
                        </div>
                      </div>
                      <div
                        v-if="!isEdit"
                        class="addbtn-row col-md-3"
                      >
                        <button
                          v-if="editPermission"
                          data-toggle="modal"
                          data-target="#editAdminModal"
                          style="
                                                            font-size: 60px;
    height: 100px;
    width: 100px;
    border-radius: 50%;
    background-color: white;
                                                        "
                        >
                          <i class="fa fa-plus" />
                        </button>
                      </div>
                    </div>
                  </div>
                  <div v-else>
                    <div class="row addAdmin">
                      <div 
                        v-if="editPermission"
                        class="col-md-2"
                      >
                        <button
                          v-if="!isEdit"
                          class="addAdmin"
                          data-toggle="modal"
                          data-target="#editAdminModal"
                          style="
                                                            font-size: 60px;
                                                            background-color: white;
                                                             
                                                        "
                        >
                          <i class="fa fa-plus" />
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <modal
                  id="editAdminModal"
                  key="editAdminModal"
                  ref="editAdminModal"
                  name="editAdminModal"
                  class="model"
                  heading="Edit Administrator Details"
                  @submit="savedetails()"
                >
                  <template slot="modalBody">
                    <form validationScope="edit_administrator_form">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label
                              for="full"
                            >Full Name</label>
                            <input
                              id="fullName"
                              v-model="name"
                              v-validate="'required'"
                              name="full_name"
                              class="form-control"
                              placeholder="write Full Name here"
                            >
                            <label
                              for="position"
                            >Position</label>
                            <input
                              id="postionName"
                              v-model="role"
                              v-validate="'required'"
                              name="position_name"
                              class="form-control"
                              placeholder="write Position Name here"
                            >
                            <label
                              for="admin_phone_no"
                            >Phone Number</label>
                            <input
                              id="admin_phone_no"
                              v-model="phone_no"
                              v-validate="'required'"
                              name="admin_phone_no"
                              class="form-control"
                              placeholder="write Admin Phone Number here"
                            >
                          </div>
                        </div>
                      </div>
                    </form>
                  </template>
                </modal>
              </Accordion>
              <Accordion
                v-if="instituteVerified===true"
                title="Instagram"
              >
                <div class="card-body">
                  <div class="col-md-3">
                    <blockquote
                      class="instagram-media"
                      data-instgrm-captioned
                      data-instgrm-permalink="https://www.instagram.com/reel/Ceq_zDhATZb/?utm_source=ig_embed&amp;utm_campaign=loading"
                      data-instgrm-version="14"
                      style="
                                                    background: #fff;
                                                    border: 0;
                                                    border-radius: 3px;
                                                    box-shadow: 0 0 1px 0
                                                            rgba(0, 0, 0, 0.5),
                                                        0 1px 10px 0
                                                            rgba(0, 0, 0, 0.15);
                                                    margin: 1px;
                                                    max-width: 540px;
                                                    min-width: 326px;
                                                    padding: 0;
                                                    width: 99.375%;
                                                    width: -webkit-calc(
                                                        100% - 2px
                                                    );
                                                    width: calc(100% - 2px);
                                                "
                    >
                      <div style="padding: 16px">
                        <a
                          href="https://www.instagram.com/reel/Ceq_zDhATZb/?utm_source=ig_embed&amp;utm_campaign=loading"
                          style="
                                                            background: #ffffff;
                                                            line-height: 0;
                                                            padding: 0 0;
                                                            text-align: center;
                                                            text-decoration: none;
                                                            width: 100%;
                                                        "
                          target="_blank"
                        >
                          <div
                            style="
                                                                display: flex;
                                                                flex-direction: row;
                                                                align-items: center;
                                                            "
                          >
                            <div
                              style="
                                                                    background-color: #f4f4f4;
                                                                    border-radius: 50%;
                                                                    flex-grow: 0;
                                                                    height: 40px;
                                                                    margin-right: 14px;
                                                                    width: 40px;
                                                                "
                            />
                            <div
                              style="
                                                                    display: flex;
                                                                    flex-direction: column;
                                                                    flex-grow: 1;
                                                                    justify-content: center;
                                                                "
                            >
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        border-radius: 4px;
                                                                        flex-grow: 0;
                                                                        height: 14px;
                                                                        margin-bottom: 6px;
                                                                        width: 100px;
                                                                    "
                              />
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        border-radius: 4px;
                                                                        flex-grow: 0;
                                                                        height: 14px;
                                                                        width: 60px;
                                                                    "
                              />
                            </div>
                          </div>
                          <div
                            style="
                                                                padding: 19% 0;
                                                            "
                          />
                          <div
                            style="
                                                                display: block;
                                                                height: 50px;
                                                                margin: 0 auto
                                                                    12px;
                                                                width: 50px;
                                                            "
                          >
                            <!-- eslint-disable  -->
                            <svg
                              width="50px"
                              height="50px"
                              viewBox="0 0 60 60"
                              version="1.1"
                              xmlns="https://www.w3.org/2000/svg"
                              xmlns:xlink="https://www.w3.org/1999/xlink"
                            >
                          <!-- eslint-disable  -->

                              <g
                                stroke="none"
                                stroke-width="1"
                                fill="none"
                                fill-rule="evenodd"
                              >
                                <g
                                  transform="translate(-511.000000, -20.000000)"
                                  fill="#000000"
                                >
                                  <g>
                                    <path
                                      d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"
                                    />
                                  </g>
                                </g>
                              </g>
                            </svg>
                          </div>
                          <div
                            style="
                                                                padding-top: 8px;
                                                            "
                          >
                            <div
                              style="
                                                                    color: #3897f0;
                                                                    font-family: Arial,
                                                                        sans-serif;
                                                                    font-size: 14px;
                                                                    font-style: normal;
                                                                    font-weight: 550;
                                                                    line-height: 18px;
                                                                "
                            >
                              View this post
                              on Instagram
                            </div>
                          </div>
                          <div
                            style="
                                                                padding: 12.5% 0;
                                                            "
                          />
                          <div
                            style="
                                                                display: flex;
                                                                flex-direction: row;
                                                                margin-bottom: 14px;
                                                                align-items: center;
                                                            "
                          >
                            <div>
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        border-radius: 50%;
                                                                        height: 12.5px;
                                                                        width: 12.5px;
                                                                        transform: translateX(
                                                                                0px
                                                                            )
                                                                            translateY(
                                                                                7px
                                                                            );
                                                                    "
                              />
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        height: 12.5px;
                                                                        transform: rotate(
                                                                                -45deg
                                                                            )
                                                                            translateX(
                                                                                3px
                                                                            )
                                                                            translateY(
                                                                                1px
                                                                            );
                                                                        width: 12.5px;
                                                                        flex-grow: 0;
                                                                        margin-right: 14px;
                                                                        margin-left: 2px;
                                                                    "
                              />
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        border-radius: 50%;
                                                                        height: 12.5px;
                                                                        width: 12.5px;
                                                                        transform: translateX(
                                                                                9px
                                                                            )
                                                                            translateY(
                                                                                -18px
                                                                            );
                                                                    "
                              />
                            </div>
                            <div
                              style="
                                                                    margin-left: 8px;
                                                                "
                            >
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        border-radius: 50%;
                                                                        flex-grow: 0;
                                                                        height: 20px;
                                                                        width: 20px;
                                                                    "
                              />
                              <div
                                style="
                                                                        width: 0;
                                                                        height: 0;
                                                                        border-top: 2px
                                                                            solid
                                                                            transparent;
                                                                        border-left: 6px
                                                                            solid
                                                                            #f4f4f4;
                                                                        border-bottom: 2px
                                                                            solid
                                                                            transparent;
                                                                        transform: translateX(
                                                                                16px
                                                                            )
                                                                            translateY(
                                                                                -4px
                                                                            )
                                                                            rotate(
                                                                                30deg
                                                                            );
                                                                    "
                              />
                            </div>
                            <div
                              style="
                                                                    margin-left: auto;
                                                                "
                            >
                              <div
                                style="
                                                                        width: 0px;
                                                                        border-top: 8px
                                                                            solid
                                                                            #f4f4f4;
                                                                        border-right: 8px
                                                                            solid
                                                                            transparent;
                                                                        transform: translateY(
                                                                            16px
                                                                        );
                                                                    "
                              />
                              <div
                                style="
                                                                        background-color: #f4f4f4;
                                                                        flex-grow: 0;
                                                                        height: 12px;
                                                                        width: 16px;
                                                                        transform: translateY(
                                                                            -4px
                                                                        );
                                                                    "
                              />
                              <div
                                style="
                                                                        width: 0;
                                                                        height: 0;
                                                                        border-top: 8px
                                                                            solid
                                                                            #f4f4f4;
                                                                        border-left: 8px
                                                                            solid
                                                                            transparent;
                                                                        transform: translateY(
                                                                                -4px
                                                                            )
                                                                            translateX(
                                                                                8px
                                                                            );
                                                                    "
                              />
                            </div>
                          </div>
                          <div
                            style="
                                                                display: flex;
                                                                flex-direction: column;
                                                                flex-grow: 1;
                                                                justify-content: center;
                                                                margin-bottom: 24px;
                                                            "
                          >
                            <div
                              style="
                                                                    background-color: #f4f4f4;
                                                                    border-radius: 4px;
                                                                    flex-grow: 0;
                                                                    height: 14px;
                                                                    margin-bottom: 6px;
                                                                    width: 224px;
                                                                "
                            />
                            <div
                              style="
                                                                    background-color: #f4f4f4;
                                                                    border-radius: 4px;
                                                                    flex-grow: 0;
                                                                    height: 14px;
                                                                    width: 144px;
                                                                "
                            /></div></a>
                        <p
                          style="
                                                            color: #c9c8cd;
                                                            font-family: Arial,
                                                                sans-serif;
                                                            font-size: 14px;
                                                            line-height: 17px;
                                                            margin-bottom: 0;
                                                            margin-top: 8px;
                                                            overflow: hidden;
                                                            padding: 8px 0 7px;
                                                            text-align: center;
                                                            text-overflow: ellipsis;
                                                            white-space: nowrap;
                                                        "
                        >
                          <a
                            href="https://www.instagram.com/reel/Ceq_zDhATZb/?utm_source=ig_embed&amp;utm_campaign=loading"
                            style="
                                                                color: #c9c8cd;
                                                                font-family: Arial,
                                                                    sans-serif;
                                                                font-size: 14px;
                                                                font-style: normal;
                                                                font-weight: normal;
                                                                line-height: 17px;
                                                                text-decoration: none;
                                                            "
                            target="_blank"
                          >A post shared by 👑
                            Fan page 👑
                            (@beingshalini_shadab.27)</a>
                        </p>
                      </div>
                    </blockquote>
                  </div>
                </div>
              </Accordion>
              
           
              <!-- contact-us section -->

              <Accordion title="Contact-Us"
               v-if="instituteVerified===true">
                <div
                v-if="editPermission" class="edit-btn-row">
                  <button
                    v-if="isEdit"
                    type="button"
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#addContactModal"
                    @click="addContactDetails"
                  >
                    Add
                  </button>
                  <button
                   v-else
                    type="button"
                    class="btn btn-primary"
                    @click="
                      saveContactDetails()
                    "
                  >
                    Save
                  </button>
                </div>
                       
                <div class="card-body">
                  <div
                    v-for="(
                      institute_contact, index
                    ) in institute_contacts"
                    :key="index"
                    class="row"
                  >
                    <div class="col-md-3">
                      <h5>
                        <i
                          class="fas fa-envelope"
                        />Email
                      </h5>
                      <p>
                        {{
                          institute_contact.email
                        }}
                      </p>
                    </div>
                    <div class="col-md-2">
                      <h5>
                        <i
                          class="fas fa-phone-alt"
                        />Phone
                      </h5>
                      <p>
                        {{
                          institute_contact.phone_no
                        }}<br>{{
                          institute_contact.phone_no2
                        }}
                      </p>
                    </div>
                    <div class="col-md-2">
                      <h5>
                        <i
                          class="fas fa-phone-alt"
                        />Department
                      </h5>
                      <p>
                        {{
                          institute_contact.department
                        }}
                      </p>
                    </div>
                      
                    <div class="col-md-4">
                      <h5>
                        <i
                          class="fas fa-user-plus"
                        />Follow Us
                      </h5>
                      <div class="row">
                        <ul
                          class="social-network social-circle"
                        >
                          <li>
                            <a
                              target="_blank"
                              :href="
                                institute.fb_url
                                  ? institute.fb_url
                                  : '#'
                              "
                              :disabled="
                                institute.fb_url
                                  ? false
                                  : true
                              "
                              :class="[
                                'icoFacebook',
                                institute.fb_url
                                  ? ''
                                  : 'disabled',
                              ]"
                              title="Facebook"
                            ><i
                              class="fab fa-facebook-f"
                            /></a>
                          </li>
                          <li>
                            <a
                              target="_blank"
                              :href="
                                institute.twitter_url
                                  ? institute.twitter_url
                                  : '#'
                              "
                              :disabled="
                                institute.twitter_url
                                  ? false
                                  : true
                              "
                              :class="[
                                icoTwitter,
                                institute.twitter_url
                                  ? ''
                                  : 'disabled',
                              ]"
                              title="Twitter"
                            ><i
                              class="fab fa-twitter"
                            /></a>
                          </li>
                          <li>
                            <a
                              target="_blank"
                              :href="
                                institute.insta_url
                                  ? institute.insta_url
                                  : '#'
                              "
                              :disabled="
                                institute.insta_url
                                  ? false
                                  : true
                              "
                              :class="[
                                icoInstagram,
                                institute.insta_url
                                  ? ''
                                  : 'disabled',
                              ]"
                              title="Instagram"
                            ><i
                              class="fab fa-instagram"
                            /></a>
                          </li>
                          <li>
                            <a
                              target="_blank"
                              :href="
                                institute.linkedin_url
                                  ? institute.linkedin_url
                                  : '#'
                              "
                              :disabled="
                                institute.linkedin_url
                                  ? false
                                  : true
                              "
                              :class="[
                                icoLinkedin,
                                institute.linkedin_url
                                  ? ''
                                  : 'disabled',
                              ]"
                              title="Linkedin"
                            ><i
                              class="fab fa-linkedin"
                            /></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div
                      class="contact-btn-col"
                      style="margin-bottom:20px"
                    >
                      <button
                      v-if="editPermission"
                        type="button"
                        class="btn btn-primary"
                        data-placement="top"
                        title="Edit"
                        data-toggle="modal"
                        data-target="#addContactModal"
                        @click="
                          editContact(
                            institute_contact
                          )
                        "
                      >
                        <i
                          class="fas fa-pencil-alt"
                          style="color: white"
                        />
                        Edit
                      </button>
                      <button
                      v-if="editPermission"
                        class="btn btn-primary"
                        type="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Delete"
                        @click="
                          deleteContact(
                            institute_contact
                          )
                        "
                      >
                        <i class="fa fa-trash" />
                      </button>
                    </div>
                  </div>
                </div>
                <modal
                  id="addContactModal"
                  key="addContactModal"
                  ref="addContactModal"
                  name="addContactModal"
                  class="model-md"
                  heading="Add Contact Details"
                  @submit="addOrEditContact()"
                >
                  <template slot="modalBody">
                    <form validationScope="add_contact_form">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                           
                                <label
                                  for="email"
                                >Email</label>
                                <input
                                  id="email"
                                  v-model="
                                    edit_institute_contact.email
                                  "
                                  v-validate="'required'"
                                  name="email"
                                  class="form-control"
                                  placeholder="write Email here"
                                ><span
                                  class="text-danger"
                                >{{ formErrors("add_contact_form.email") }}</span>
                                <label
                                  for="phone_no"
                                >Phone Number</label>
                                <input
                                  id="phone_no"
                                  v-model="
                                    edit_institute_contact.phone_no
                                  "
                                  v-validate="'required'"
                                  name="phone_no"
                                  class="form-control"
                                  placeholder="write Phone Number here"
                                ><span
                                  class="text-danger"
                                >{{
                                  formErrors(
                                    "add_contact_form.phone_no"
                                  )
                                }}</span>
                                <label
                                  for="phone_no2"
                                >Phone Number2</label>
                                <input
                                  id="phone_no2"
                                  v-model="
                                    edit_institute_contact.phone_no2
                                  "
                                  name="phone_no2"
                                  class="form-control"
                                  placeholder="write Phone Number here"
                                >
                                <label
                                  for="department"
                                >Department Name</label>
                                <input
                                  id="department"
                                  v-model="
                                    edit_institute_contact.department
                                  "
                                  name="department"
                                  class="form-control"
                                  placeholder="write Department Name here"
                                >
                          </div>
                        </div>
                      </div>
                    </form>
                  </template>
                </modal>
              </Accordion>
             
     
              <!-- location section -->
              <Accordion title="Location"
               v-if="instituteVerified===true">
                <div class="card-body">
                  <div
                    class="flex"
                    style="background: #fff"
                  >
                    <div class="col-12">
                      <div class="mapouter">
                        <div class="gmap_canvas">
                          <iframe
                            id="gmap_canvas"
                            width="100%"
                            height="500px"
                            src="https://maps.google.com/maps?q=26.9024375%2075.78706249999999&t=&z=16&ie=UTF8&iwloc=&output=embed"
                          /><a
                            href="https://yt2.org/youtube-to-mp3-ALeKk00qEW0sxByTDSpzaRvl8WxdMAeMytQ1611842368056QMMlSYKLwAsWUsAfLipqwCA2ahUKEwiikKDe5L7uAhVFCuwKHUuFBoYQ8tMDegUAQCSAQCYAQCqAQdnd3Mtd2l6"
                          /><br>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </Accordion>
            </div>
          </div>
        </template>

        <template slot="tab-heading-posts">
          {{ "Posts" }}
        </template>
        <template slot="tab-panel-posts">
          <PostContainer
            v-if="AuthUser.preferred_institute_id"
            :post-route="
              '/institute/' + AuthUser.preferred_institute_id
            "
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align: center">
                Currently no post have been shared in your
                institute.
              </p>
            </template>
          </PostContainer>
        </template>
        <template slot="tab-heading-doubts">
          {{ "Doubts" }}
        </template>
        <template slot="tab-panel-doubts">
          <DoubtContainer
            v-if="AuthUser.preferred_course_id"
            :doubt-route="'/course/' + AuthUser.preferred_course_id"
          >
            <template slot="empty">
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align: center">
                Currently no doubt have been shared in your
                institute.
              </p>
            </template>
          </DoubtContainer>
        </template>
      </nav-tabs>
    </div>
    <!-- fotter for update chnges -->
    <div
      v-if="data_updated"
      class="static-footer"
    >
      <div class="col-md-12 mt-2 mb-2">
        <div class="text-right">
          <button
          v-if="editPermission"
            class="btn btn-primary mr-2"
            type="button"
            @click="saveProfile"
          >
            Update
          </button>
          <button
          v-if="editPermission"
            type="button"
            class="btn btn-secondary"
            @click="discard"
          >
            Discard
          </button>
        </div>
      </div>
    </div>
    </div>
  </section>
</template>
<style scoped>
.bottom-right {
    position: absolute;
    background-color: white;
    bottom: 239px;
    right: 35px;
}
.container {
    position: relative;
}
.bottom-left {
    position: absolute;
    bottom: 10px;
    left: 115px;
}
.profile-form {
    margin-top: 20px;
}
.col-md-12 {
    margin-top: 10px;
}
.profile-info {
    margin-top: 30px;
}

.delete_Institute_User {
    position: absolute;
    background-color: white;
    bottom: 156px;
    right: -35px;
}
.Administrator-profile {
  display: inline-flex;
  flex-direction: column;
  flex-wrap: nowrap;
  justify-content: flex-start;
  gap: 5px;
  text-align: center;
}
.edit-btn-row {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: flex-end;
  align-items: center;
  align-content: center;
}

@media (max-width: 769px)  {
.addAdmin{
text-align: center;
}
}

@media (max-width: 769px)  {
.EditBanner{
  height: 45px;
    width: 111px;
    position: absolute;
    background-color: white;
    bottom: 265px;
    right: 35px;
}
}

@media (max-width: 769px)  {
.institute-avatar{
    margin-left: 0px !important;
}
}
@media (max-width: 769px)  {
.edit-avatar{
    
    position: absolute;
    bottom: 5px;
    left: 100px;
}
}
@media   (max-width:769px) {
  .addbtn-row {
    /* flex-direction: column; */
    text-align: center;
  }
}

@media   (max-width:769px) {
  .instagram-media {
    /* flex-direction: column; */
    min-width: 100% !important;
  }
}



</style>

import Accordion from "../../components/accordion.vue";
<script async src="//www.instagram.com/embed.js" />
<script>
import Accordion from "@/components/accordion.vue";

import NavTabs from "../../components/NavTabs";
import SelectInstitute from "../../components/SelectInstitute.vue";
import PostContainer from "./post-container.vue";
import DoubtContainer from "@/Pages/doubt/doubt-container.vue";
import SocialSharing from "vue-social-sharing";
import swal from "../../components/swal";
import FileUpload from "vue-upload-component";
import Modal from "../../components/VueNiceModal.vue";
import FormMixin from "../../components/mixins/form-mixin.js";
import RichTextEditor from '../../components/RichTextEditor';

export default {
    components: {
        Accordion,
        NavTabs,
        PostContainer,
        DoubtContainer,
        SelectInstitute,
        SocialSharing,
        FileUpload,
        Modal,
        RichTextEditor,
    },
    mixins: [FormMixin],
    props:['editPermission','instituteVerified'],
    data() {
        return {
            institute_banner_url: "",
            logo_url: "",
            institute: "",
            institute_users: [],
            institute_contacts: [],
            edit_institute_contact: {
                email: "",
                phone_no: "",
                phone_no2: "",
            },
            edit_institute: {
                website: "",
                address: "",
            },
            user_id: "",
            role: "",
            phone_no: "",
            name: "",
            teachers: [],
            students: [],
            posts: [],
            errors: {
                fb_url: "",
                twitter_url: "",
                insta_url: "",
                linkedin_url: "",
                youtube_vedio_url: "",
            },

            initialTab: "posts",
            tabs: ["posts", "doubts", "students", "teachers"],
            showLoader: true,
            selected_institute: {
                id: null,
                name: "",
            },
            data_updated: false,
            isEdit: true,
            new_blog: '',
        };
    },
    computed: {
        isCourseValid() {
            if (this.selected_institute && this.selected_institute.name) {
                return true;
            }
            return false;
        },
    },
    mounted() {
        this.initiateData();
        if (this.AuthUser.role !== 'instituteAdmin' && this.instituteVerified==false) {
            this.tabs.pop("about");
            console.log(this.tabs.pop);
        }
        else{
            this.tabs.unshift("about");
            this.initialTab = "about";
        }
        let institute_id = this.AuthUser.preferred_institute_id;

        if (!institute_id) return false;

        this.axios
            .get("/api/institute/" + (institute_id ? institute_id : ""))
            .then((resp) => {
                this.institute_users = resp.data.success.institute_users;
                this.institute_contacts = resp.data.success.institute_contacts;
                this.teachers = resp.data.success.teachers;
                this.institute = resp.data.success.institute;
                this.students = resp.data.success.students;
            });
    },
    methods: {
        addAdministrator() {
            this.$modal.show("editAdminModal");
        },

        savedetails() {
            this.showLoader = true;
            this.axios
                .post(this.baseUrl + "/api/add-details", {
                    name: this.name,
                    user_id: this.user_id,
                    role: this.role,
                    phone_no: this.phone_no,
                })
                .then((resp) => {
                    this.showLoader = false;
                    this.institute_users.push({
                        name: resp.data.success.institute_user.name,
                        institute_id:
                            resp.data.success.institute_user.institute_id,
                        user_id: resp.data.success.institute_user.user_id,
                        role: resp.data.success.institute_user.role,
                        phone_no: resp.data.success.institute_user.phone_no,
                        id: resp.data.success.institute_user.id,
                    });                    
                });
                console.log(this.$refs.editAdminModal)
            this.$refs.editAdminModal.closeModal();
            this.clearModalData();
        },
        deleteInstituteUser(instituteuser) {
           let loader = this.$loading.show(); 
            this.axios
                .delete("/api/instituteuser/" + instituteuser.id)
                .then((resp) => {
                   loader.hide();
                    let index = this.institute_users.findIndex(
                        (el) => el.id === instituteuser.id
                    );
                    this.institute_users.splice(index, 1);
                });
        },
        dataUpdated() {
            this.data_updated = true;
        },
        initiateData() {
          this.showLoader = false;
            if (this.institute) {
                this.institute = Object.assign({}, this.institute.profile);
            } else {
                this.institute = {
                    fb_url: "",
                    twitter_url: "",
                    insta_url: "",
                    linkedin_url: "",
                    youtube_vedio_url: "",
                    address:"",
                    website:"",
                    city:"",
                    state:"",
                };
            }
        },
        discard() {
            this.initiateData();
            this.data_updated = false;
        },
        async saveProfile() {
          this.showLoader = true;
            if (
                this.institute.fb_url &&
                !this.institute.fb_url.includes("facebook.com")
            ) {
                this.errors.fb_url = "This is not valid Facebook url.";
                return false;
            }
            if (
                this.institute.twitter_url &&
                !this.institute.twitter_url.includes("twitter.com")
            ) {
                this.errors.twitter_url = "This is not valid Twitter url.";
                return false;
            }
            if (
                this.institute.insta_url &&
                !this.institute.insta_url.match(/^[a-zA-Z0-9_.]*$/g)
            ) {
                this.errors.insta_url = "This is not valid Instagram username.";
                return false;
            }
            if (
                this.institute.linkedin_url &&
                !this.institute.linkedin_url.includes("linkedin.com")
            ) {
                this.errors.linkedin_url = "This is not valid Linkedin url.";
                return false;
            }
            if (
                this.institute.youtube_vedio_url &&
                !this.institute.youtube_vedio_url.includes("youtube.com")
            ) {
                this.errors.youtube_vedio_url =
                    "This is not valid Youtube url.";
                return false;
            }

            await this.axios
                .post(
                    "/api/save-institute-profile",
                    Object.assign({}, this.institute)
                )
                .then((resp) => {
                  this.showLoader = false;
                    this.setProfile(resp.data.success.profile);
                    swal.successDialog(
                        "Profile Updated",
                        "Successfully!",
                        "success"
                    );
                    this.data_updated = false;
                });

            this.errors = {
                fb_url: "",
                twitter_url: "",
                insta_url: "",
                linkedin_url: "",
                youtube_vedio_url: "",
            };
        },
        setProfile(profile) {
            this.institute.fb_url = profile.fb_url ? profile.fb_url : "";
            this.institute.twitter_url = profile.twitter_url
                ? profile.twitter_url
                : "";
            this.institute.insta_url = profile.insta_url
                ? profile.insta_url
                : "";
            this.institute.linkedin_url = profile.linkedin_url
                ? profile.linkedin_url
                : "";
            this.institute.youtube_vedio_url = profile.youtube_vedio_url
                ? profile.youtube_vedio_url
                : "";
        },
        inputUpdate(files) {
            this.image = files[0];
            this.institute_banner_url = URL.createObjectURL(files[0].file);
        },
        editAdmiDetails() {
            this.isEdit = false;
        },
        saveAdmiDetails() {
            window.location.reload();
        },
        editContactDetails() {
            this.isEdit = false;
        },
        saveContactDetails() {
            window.location.reload();
        },
        addOrEditContact() {
            this.validateForm('add_contact_form').then((valid) => {
              console.log(valid);
                if (valid) {
                    this.contactCreateOrUpdateApi();
                }
            });
        },
        contactCreateOrUpdateApi() {
           let loader = this.$loading.show(); 
            this.axios
                .post(this.baseUrl + "/api/add-contact", {
                    email: this.edit_institute_contact.email,
                    phone_no: this.edit_institute_contact.phone_no,
                    phone_no2: this.edit_institute_contact.phone_no2,
                    department: this.edit_institute_contact.department,
                    website: this.edit_institute.website,
                    address: this.edit_institute.address,
                    edit_institute_contact_id: this.edit_institute_contact.id,
                })
                .then((resp) => {
                    loader.hide();
                    this.edit_institute_contact.push({
                        email: resp.data.success.edit_institute_contact.email,
                        phone_no:
                            resp.data.success.edit_institute_contact.phone_no,
                        phone_no2:
                            resp.data.success.edit_institute_contact.phone_no2,
                        department:resp.data.success.edit_institute_contact.department,
                        id: resp.data.success.edit_institute_contact.id,
                        website: resp.data.success.edit_institute.website,
                        address: resp.data.success.edit_institute.address,
                    });
                    this.$refs.addContactModal.closeModal();
                    this.clearModalData();
                });
        },
        // set contact data in add edit modal
        editContact(edit_institute_contact) {
            this.edit_institute_contact = edit_institute_contact;
        },
        deleteContact(edit_institute_contact) {
           let loader = this.$loading.show(); 
            this.axios
                .delete("/api/contact/" + edit_institute_contact.id)
                .then((resp) => {
                  loader.hide();
                    let index = this.institute_contacts.findIndex(
                        (el) => el.id === edit_institute_contact.id
                    );
                    this.institute_contacts.splice(index, 1);
                });
        },
        addContactDetails() {
            this.edit_institute_contact.email = "";
            this.edit_institute_contact.phone_no = "";
            this.edit_institute_contact.phone_no2 = "";
            this.edit_institute.website = "";
            this.edit_institute.address = "";
        },
        submitCourse() {
            this.axios
                .put("/api/preferred-details", {
                    preferred_institute: this.selected_institute,
                })
                .then((resp) => {
                    window.location.reload();
                });
        },
        clearModalData() {
            this.name = "";
            this.role = "";
            this.id = "";
        },
        	
    submitblog() {
			this.axios.post('/api/add-blog/'+this.institute.id, {
				new_blog: this.new_blog,
			})
				.then(resp => {
          this.blog = resp.data.success.blog;
					this.add_blog = false;
					this.new_blog = '';
				})
		},
    },
};
</script>
