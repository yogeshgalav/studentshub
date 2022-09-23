<template>
  <guest-layout>
    <v-app-bar color="primary" :clipped-left="false" fixed dark app>
      <v-toolbar-title v-text="appName" />
      <v-spacer />
      <Link v-if="$page.props.auth.user" :href="route('home')">
      <v-btn text>Home</v-btn>
      </Link>
      <div v-else>
        <Link :href="route('login')">
        <v-btn text>Login</v-btn>
        </Link>
        <Link :href="route('register')">
        <v-btn text>Register</v-btn>
        </Link>
      </div>
    </v-app-bar>
    <v-main>
      <v-container>
        <v-card>
          <v-card-title>Welcome to Laravel Inertia Vuetify</v-card-title>
        </v-card>
        <v-card class="mx-auto my-3 d-flex-column align-content-center rounded-t-lg" color="#fff" elevation="2"
          max-width="550px" height="500px">
          <v-img src="images/img1.jpg" class="" height="280px"></v-img>
          <div class="mx-6 mt-6 mb-0 d-flex align-center">
            <v-avatar color="blue accent-1">
              <v-icon dark>mdi-account-circle</v-icon>
            </v-avatar>
            <div class="mx-2">
              <v-text class="d-block text--primary font-weight-bold">Name</v-text>
              <v-text class="d-block text--secondary font-weight-light">Sep 21</v-text>
            </div>
          </div>
          <div class="ml-16">
            <v-hover v-slot="{ hover }">
              <v-btn text plain class="font-weight-bold display-1 text-capitalize my-4"
                :color="hover?'deep-purple accent-4':'indigo darken-4'">Learning vuetify
              </v-btn>
              <v-row class="mx-2">
                <v-btn text x-small class="pa-2 mx-1 rounded text--secondary">#javascript</v-btn>
                <v-btn text x-small class="pa-2 mx-1 rounded text--secondary">#css</v-btn>
                <v-btn text x-small class="pa-2 mx-1 rounded text--secondary">#vue</v-btn>
                <v-btn text x-small class="pa-2 mx-1 rounded text--secondary">#bootstrap</v-btn>
              </v-row>
            </v-hover>
            <div class="my-6 d-inline-flex mx-2">
              <div class="d-inline-flex align-center">
                <v-btn text class=" rounded">
                  <v-icon small color="grey">mdi-heart-outline</v-icon>
                  <v-text class="font-weight-thin text-capitalize mx-2 text--secondary">Likes</v-text>
                </v-btn>
              </div>
              <div class="d-inline-flex align-center mx-4">
                <v-btn text class="pa-1 rounded">
                  <v-icon small color="grey">mdi-comment-outline</v-icon>
                  <v-text class="font-weight-thin text-capitalize mx-2 text--secondary">Comments</v-text>
                </v-btn>
              </div>
            </div>
          </div>
        </v-card>
      </v-container>
    </v-main>
  </guest-layout>
</template>

<script>
// import { mdiHeartOutline } from '@mdi/js';
import ApplicationLogo from '../components/ApplicationLogo.vue'
import GuestLayout from '../layouts/GuestLayout.vue'
export default {
  components: { ApplicationLogo, GuestLayout },
  computed: {
    appName() {
      return this.$page.props.appName
    },
  },

}


</script>
