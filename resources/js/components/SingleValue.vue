<template>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center mx-auto">
        <router-link
          v-if="link"
          :to="link"
        >
          {{ value }}
          <br>
          {{ label }}
        </router-link>
        <div v-else>
          {{ value }}
          <br>
          {{ label }}
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>

</style>
<script>
export default {
	props:{
		value:{

			required: true
		},
		label:{
			type: String,
			required: true
		},
		link:{
			type: String,
			default: '',
			required:false
		}
	},

};
</script>
