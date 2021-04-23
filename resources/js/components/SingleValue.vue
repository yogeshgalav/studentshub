<template>
    <div class="card col-sm-5 col-md-3">
        <div class="card-body text-center mx-auto">
            {{value}}
            <br>
            {{label}}
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
			type: String,
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

}
</script>
