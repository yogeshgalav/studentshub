<template>
  <div class="sidebar">
    <div class="sidebar-navigation mt-5">
      <ul>
        <div>
          <span
            class="closebtn btndisplay"
            @click="sidebarItemClick"
          >x</span>
        </div>

        <router-link
          href="/"
          :class="isUrl('post') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fa fa-home "
              aria-hidden="true"
            /><span class="text">Home</span>
          </li>
        </router-link>
        <router-link
          href="/category"
          :class="isUrl('category') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fa fa-list"
              aria-hidden="true"
            /><span class="text">Category</span>
          </li>
        </router-link>
        <router-link
          href="/doubts"
          :class="isUrl('doubt') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fa fa-question-circle "
              aria-hidden="true"
            />
            <span class="text">Doubts</span>
          </li>
        </router-link>
        <router-link
          href="/my-course"
          :class="isUrl('my-course') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fas fa-book-open"
              aria-hidden="true"
            />
            <span class="text">My Course</span>
          </li>
        </router-link>
            
        <router-link
          href="/classrooms"
          :class="isUrl('classroom') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fa fa-desktop "
              aria-hidden="true"
            /><span class="text">Classrooms</span>
          </li>
        </router-link>
        <router-link
          v-if="AuthUser.role==='student'"
          href="/my-reports"
          :class="isUrl('my-reports') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fas fa-chart-line"
              aria-hidden="true"
            />
            <span class="text">My Reports</span>
          </li>
        </router-link>
        <router-link
          href="/chatroom"
          :class="isUrl('chatroom') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="far fa-comment-dots"
              aria-hidden="true"
            />
            <span class="text"> Chatroom</span>
          </li>
        </router-link>
            
        <router-link
          href="/my-institute"
          :class="isUrl('institute') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fas fa-university "
              aria-hidden="true"
            /><span class="text"> My
              Institute</span>
          </li>
        </router-link>
            
        <router-link
          v-if="0"
          href="/students"
          :class="isUrl('students') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fas fa-users "
              aria-hidden="true"
            />
            <span class="text">Students</span>
          </li>
        </router-link>
        <router-link
          v-if="AuthUser.role==='student'"
          href="/classmates"
          :class="isUrl('classmates') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fas fa-users"
              aria-hidden="true"
            /><span class="text">
              Classmates</span>
          </li>
        </router-link>
        <router-link
          v-if="AuthUser.role==='student'"
          href="/more-apps"
          :class="isUrl('more-apps') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="fas fa-tablet-alt"
              aria-hidden="true"
            />
            <span class="text">More Apps</span>
          </li>
        </router-link>
        <router-link
          :href="'/profile/'+AuthUser.id"
          :class="isUrl('profile') ? 'active' : ''"
          @click="sidebarItemClick"
        >
          <li>
            <i
              class="far fa-user"
              aria-hidden="true"
            />
            <span class="text">Profile</span>
          </li>
        </router-link>
      </ul>
    </div>
  </div>
</template>
<style scoped>
.closebtn {
    font-size: x-large;
    top: 15px;
    line-height: 36px;
    height: 42px;
    color: black;
    position: absolute;
    right: 15px;
}

</style>
<script>
export default {
	methods:{
		closeClick: function() {
			this.$refs.sidebar.hide();
		},

		isUrl(...urls) {
			let currentUrl = this.$page.url.substr(1);
			if (urls[0] === '') {
				return currentUrl === '';
			}
			return urls.filter((url) => currentUrl.startsWith(url)).length;
		},
		sidebarItemClick(){
			var container = document.getElementById('sidebar-section');
			container.classList.remove('sidebar-section-active');
		}
	}
};
</script>