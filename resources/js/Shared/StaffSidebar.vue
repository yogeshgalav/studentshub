<template>
  <div class="sidebar">
    <div class="sidebar-navigation mt-5">
      <ul>
        <router-link
          href="/manage-users"
        >
          <li>
            <span class="text">Manage Users</span>
          </li>
        </router-link>
        <router-link
          href="/manage-courses"
        >
          <li>
            <span class="text">Manage Courses</span>
          </li>
        </router-link>
        <router-link
          href="/manage-jobs"
        >
          <li>
            <span class="text">Manage Careers</span>
          </li>
        </router-link>
        <router-link
          href="/user-feedbacks"
        >
          <li>
            <span class="text">User Feedbacks</span>
          </li>
        </router-link>
        <router-link
          href="/user-reports"
        >
          <li>
            <span class="text">User Reports</span>
          </li>
        </router-link>
        <router-link
          href="/transaction-details"
        >
          <li>
            <span class="text">Transaction Details</span>
          </li>
          <router-link
            href="/membership-details"
          >
            <li>
              <span class="text">Membership Details</span>
            </li>
          </router-link>
        </router-link>
        <router-link
          href="/institutes"
        >
          <li>
            <span class="text">Institutes</span>
          </li>
        </router-link>
      </ul>
    </div>
  </div>
</template>
<script>
export default {

};
</script>