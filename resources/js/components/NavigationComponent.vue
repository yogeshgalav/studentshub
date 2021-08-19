<template>
  <div
    class="static-footer"
  >
    <div class="col-md-12">
      <div
        class="row"
      >
        <div class="col-md-12">
          <div class="row mt-2">
            <div class="col-3 text-right">
              <button
                class="btn btn-secondary"
                :disabled="!hasprev"
                type="button"
                @click="prevStud"
              >
                <i class="fas fa-chevron-left" />
              </button>
            </div>
            <div class="col-7 text-center">
              <span>{{ current_user_name }}</span><br>
              <span>{{ curIndex +1 }} / {{ studentIds.length }}</span>
            </div>
            <div class="col-2 text-right">
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