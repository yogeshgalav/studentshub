<template>
  <div
    class="habit-footer"
  >
    <div class="col-md-12">
      <div
        class="row habit-footer_1 mt-1 ml-280"
      >
        <div class="col-md-6   text-right">
          <div class="mr-3">
            <button
              class="btn btn-secondary"
              :disabled="!hasprev"
              type="button"
              @click="prevStud"
            >
              <i class="fas fa-chevron-left" />
            </button>
            <p>{{ current_user_name }}</p>
            <button
              type="button"
              class="btn btn-secondary"
              :disabled="!hasnext"
              @click="nextStud"
            >
              <i class="fas fa-chevron-right" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	props:['currentUserId'],
	data(){
		return {
			current_user_name:'',
			curIndex:'',
			studentIds:[],
		};
	},
	computed:{
		hasprev() {
			return this.curIndex - 1 >= 0;
		},
		hasnext() {
			return this.curIndex + 1 <= this.studentIds.length - 1;
		},
	},
	mounted(){
		this.studentIds = JSON.parse(localStorage.getItem('studentids'));
		//getting the index from the current user array
		this.curIndex = this.studentIds.findIndex((element) => element.user_id === parseInt(this.currentUserId));
		//setting the name
		this.current_user_name = this.studentIds[this.curIndex].user_name;
	},
	methods:{
		nextStud(){
			if (this.hasnext) {
				this.curIndex += 1;
				this.$emit('changeUser', this.studentIds[this.curIndex].user_id);
				this.current_user_name = this.studentIds[this.curIndex].user_name;
			}
		},
		prevStud(){
			if (this.hasprev) {
				this.curIndex -= 1;
				this.$emit('changeUser', this.studentIds[this.curIndex].user_id);
				this.current_user_name = this.studentIds[this.curIndex].user_name;
			}
		},
	}
};
</script>