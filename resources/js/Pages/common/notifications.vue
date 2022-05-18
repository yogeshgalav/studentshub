<template>
  <div class="full-size">
    <Head>
      <title>Notifications</title>
    </Head>
    <div class="classmates-section col-md-7 col-sm-12">
      <div
        v-if="!notifications.length"
        class="classmate card mb-2"
      >
        <div class="row">
          <div class="text-center col-md-12 notification">
            <div class="notification-text text-black">
              {{ "Currently you don't have any not notifications." }}
            </div>
          </div>
        </div>
      </div>
      <a
        v-for="(notification,index) in notifications"
        :key="index"
        :href="notification.url"
      >
        <div class="classmate card mb-2">
          <div class="row">
            <div class="text-center col-md-12 notification">
            
              <div
                style="text-align: -webkit-center"
                class=" pl-0"
              >
                <profile-image
                  :user-name="notification.avatar_name"
                  :avatar="notification.avatar_url"
                  size="large"
                />
              </div>

              <div class="notification-text text-black">
                {{ notification.body }}
              </div>
            <!-- <div class="time-gap text-grey">
              12 hours ago
            </div> -->
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>
<style scoped>
.notification {
    display: flex;
    align-items: center;
}
.notification-text {
    text-align: left;
    padding: 0px 10px;
}
.card {
    padding: 10px 5px;
    margin: auto;
}
.time-gap {
    position: absolute;
    top: 10px;
    right: 0px;
}
.row {
    display: flex;
}
.classmates-section {
    margin: auto;
}
</style>
<script>
export default {
	data(){
		return {
			notifications:[],
		};
	},
	mounted(){
		this.axios.get('/api/notifications').then(resp=>{
			this.notifications = resp.data.success.notifications;
		});
	}
};
</script>
