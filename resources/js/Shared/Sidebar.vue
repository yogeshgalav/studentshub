<template>
  <div class="sidebar">
    <div class="sidebar-navigation mt-5">
      <ul>
        <link
          href="/"
          :class="isUrl('post') ? 'active' : ''"
        >
        <li>
          <i
            class="fa fa-home "
            aria-hidden="true"
          /><span class="text">Home</span>
        </li>
        </link>
        <link
          href="/doubts"
          :class="isUrl('doubt') ? 'active' : ''"
        >
        <li>
          <i
            class="fa fa-question-circle "
            aria-hidden="true"
          />
          <span class="text">Doubts</span>
        </li>
        </link>
            
        <link
          href="/my-course"
          :class="isUrl('my-course') ? 'active' : ''"
        >
        <li>
          <i
            class="fas fa-book-open"
            aria-hidden="true"
          />
          <span class="text">My Course</span>
        </li>
        </link>
            
        <link
          href="/classrooms"
          :class="isUrl('classroom') ? 'active' : ''"
        >
        <li>
          <i
            class="fa fa-desktop "
            aria-hidden="true"
          /><span class="text">Classrooms</span>
        </li>
        </link>
        <link
          v-if="AuthUser.role_intended==='student'"
          href="/my-reports"
          :class="isUrl('my-reports') ? 'active' : ''"
        >
        <li>
          <i
            class="fas fa-chart-line"
            aria-hidden="true"
          />
          <span class="text">My Reports</span>
        </li>
        </link>
        <link
          href="/messages"
          :class="isUrl('messages') ? 'active' : ''"
        >
        <li>
          <i
            class="far fa-comment-dots"
            aria-hidden="true"
          />
          <span class="text"> Messages</span>
        </li>
        </link>
            
        <link
          href="/my-institute"
          :class="isUrl('institute') ? 'active' : ''"
        >
        <li>
          <i
            class="fas fa-university "
            aria-hidden="true"
          /><span class="text"> My
            Institute</span>
        </li>
        </link>
            
        <link
          v-if="AuthUser.role_intended!=='student'"
          href="/students"
          :class="isUrl('students') ? 'active' : ''"
        >
        <li>
          <i
            class="fas fa-users "
            aria-hidden="true"
          />
          <span class="text">Students</span>
        </li>
        </link>
        <link
          v-if="AuthUser.role_intended==='student'"
          href="/classmates"
          :class="isUrl('classmates') ? 'active' : ''"
        >
        <li>
          <i
            class="fas fa-users"
            aria-hidden="true"
          /><span class="text">
            Classmates</span>
        </li>
        </link>
        <link
          v-if="AuthUser.role_intended==='student'"
          href="/more-apps"
          :class="isUrl('more-apps') ? 'active' : ''"
        >
        <li>
          <i
            class="fas fa-tablet-alt"
            aria-hidden="true"
          />
          <span class="text">More Apps</span>
        </li>
        </link>
        <link
          :href="'/profile/'+AuthUser.id"
          :class="isUrl('profile') ? 'active' : ''"
        >
        <li>
          <i
            class="far fa-user"
            aria-hidden="true"
          />
          <span class="text">Profile</span>
        </li>
        </link>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
    methods:{
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length
        }
    }
}
</script>