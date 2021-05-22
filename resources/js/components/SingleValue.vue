<template>
  <div class="card col-sm-5 col-md-3">
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
</template>
<style scoped>
.card{
    margin: 5px 5px;
    width: 200px;
}
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
