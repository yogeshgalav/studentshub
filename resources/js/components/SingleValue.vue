<template>
  <div class="col-md-4 mt-1">
    <div class="card">
      <div class="card-body text-center mx-auto">
        <Link
          v-if="link"
          :href="link"
        >
          {{ value }}
          <br>
          {{ label }}
        </Link>
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
