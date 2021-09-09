<template>
  <div>
    <div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="">
            <a
              v-if="AuthUser"
              target="_blank"
              class="btn btn-link ml-2 mb-2 font-size-18"
              @click="$router.back()"
            >
              <i
                class="fa fa-arrow-left"
                aria-hidden="true"
              />
              Back
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h1 class="font-size-24 text-black weight-800 mb-2 line-height-25-px mobile-size-heading">
          {{ homework.description }}
        </h1>       
      </div>      
      <div class="col-md-12">
        <p class="font-size-18 text-black mb-0 line-height-25-px">
          {{ 'Assigned by:' +' '+homework.teacher_name }}  
        </p>
        <p class="font-size-18 text-grey mb-0 line-height-25-px">
          {{ 'Submission date:' +' '+homework.submission_date }}  
        </p>
      </div>
      <div class="col-md-12">
        <div id="homeworkHtml" />
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr>
      </div>
    </div>
    
    <div class="col-md-12 mt-2">
      <div class="card">
        <div class="card-header">
          Homework info
        </div>
        <div class="card-body">
          <div v-if="AuthStudent">
            <button
              v-if="!markedDone"
              class="btn btn-success btn-lg"
              @click="markDone"
            >
              Mark as Done
            </button>
            <button
              v-else
              class="btn btn-seconday btn-lg"
              @click="markDone"
            >
              Marked Done
            </button>
          </div>
          <vue-table-component
            key="homework"
            :columns="homeworkColumn"
            :rows="homeworkRow"
          >
            <template
              slot="table-row"
              slot-scope="props"
            >
              <span v-if="props.column.field==='marked_done_at'">
                <span
                  v-if="props.row.marked_done_at"
                  class="text-success"
                >{{ $dayjs(props.row.marked_done_at).format('D MMMM, YYYY') }}</span>
                <span
                  v-else
                  class="text-danger"
                >Not yet submitted</span>
              </span>
              <span v-else>{{ props.row[props.column.field] }}</span>
            </template>
            <div slot="emptystate">
              <p class="mt-3">
                {{ 'Currently no student has joined meeting' }}
              </p>
            </div>
          </vue-table-component>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.answer_que p {
    color: #868686;
}
h4.main_que {
    background-color: white;
    padding: 15px 15px;
    color: #868686;
    box-shadow: 0 0 2px rgba(0,0,0,0.12);
    margin-bottom: 20px;
}
</style>
<script>
import VueTableComponent from '../../components/vue-table-component';
import dayjs from 'dayjs';

export default {
	components:{
		VueTableComponent
	},
	data() {
		return {
			homework:{},
			homeworkColumn:[
				{
					label: 'Student name',
					field: 'full_name',
				},
				{
					label: 'Roll/Registration no.',
					field: 'reg_no',
				},
				{
					label: 'Marked done at',
					field: 'marked_done_at',
				},
			], 
			homeworkRow:[], 
			markedDone:false, 
		};

	},
	mounted() {
		this.getHomeworkData();
	},
	methods: {
		getHomeworkData(){
      		axios.get('/api/classroom/' + this.$route.params.classroomId + '/homework/'+this.$route.params.homework)
				.then(response => {
					this.homework = response.data.success.homework;
					this.markedDone = this.homework.user_mark ? true : false;
					this.homeworkRow = response.data.success.user_homeworks;
					this.addHomeworkHtml();
				}); 
		},
		addHomeworkHtml() {
			const div = document.createElement('div');
			div.className = 'font-size-24';
			div.innerHTML =this.homework.homework_html;
			document.getElementById('homeworkHtml').appendChild(div);
		},
		markDone() {
			this.markedDone = !this.markedDone;
			this.axios.post('/api/homework/' + this.$route.params.homework + '/mark-as-done')
				.then(resp => {
					this.error = '';
				}).catch(()=>{
					this.markedDone = !this.markedDone;
				});
		},
	}
};

</script>
