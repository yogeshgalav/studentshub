<template>
  <div>
    <Head>
      <title>Institutes</title>
    </Head>
    <div class="row">
      <div class="col-md-12">
        <h2 class="weight-800 text-black font-size-40">
          {{ 'Institutes' }}
        </h2>
        <button
          data-toggle="modal"
          data-target="#addEditInstituteModal"
          class="btn btn-primary mt-3 text-white"
          @click="addNewInstitute"
        >
          {{ 'Create new Institute' }}
        </button>
        <edit-institute-modal
          :value="edit_institute"
          @input="updateInstitute"
        />
      </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <div class="card mt-5">
          <div class="card-header">
            <h2 class="weight-800 text-black font-size-18 mb-0">
              {{ 'Institutes' }}
            </h2>
          </div>
          <div class="card-body">
            <div class="col-md-12 institute_list">
              <loading
                :key="Math.random()"
                :active.sync="loading"
                :color="'#10069F'"
                :width="100"
                :is-full-page="false"
                :opacity="0.7"
                loader="dots"
                :name="'vue-table-loading' + Math.random()"
              />
              <vue-table-component
                :columns="instituteColumns"
                :rows="instituteRows"
              >
                <template
                  slot="table-row"
                  slot-scope="props"
                >
                  <span v-if="props.column.field==='institute_name'">
                    <a
                      :href="'/institute/'+props.row.institute_id"
                      class="text-underline"
                    >{{ props.row.institute_name }}</a>
                  </span>
                  <span v-else-if="props.column.field==='is_verified'">
                    {{ props.row.is_verified ? 'Yes' : 'No' }}
                  </span>
                  <span v-else-if="props.column.field==='edit'">
                    <button
                      type="button"
                      class="btn btn-link"
                      data-toggle="modal"
                      data-target="#addEditInstituteModal"
					  @click="editInstitute(props.row)"
                    >
                      <i
                        class="fas fa-pencil-alt text-grey"
                        style="color: white"
                      />
                    </button>
                  </span>
                  <span v-else>{{ props.row[props.column.field] }}</span>
                </template>
              </vue-table-component>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueTableComponent from '../../components/vue-table-component';
import FormMixin from '../../components/mixins/form-mixin.js' ;
import Loading from 'vue-loading-overlay';
import StaffLayout from '@/Layouts/StaffLayout';
import EditInstituteModal from './edit-institute-modal.vue';
import institute2Vue from './institute2.vue';

export default {
	layout:StaffLayout,
	components: {
		VueTableComponent,
		Loading,
		EditInstituteModal
	},
	mixins: [FormMixin],
	data(){
	    return {
			form_data:{institute_name:'',language:'en-US'},
			edit_institute: {
				youtube_vedio_url:'',
				insta_url:'',
				twitter_url:'',
				fb_url:'',
				linkedin_url:'',
				website: '',
				address: '',
				city:'',
				state:'',
				moto:'',
			},
			instituteRows: [],
			instituteColumns: [
				{
					label: 'Institute',
					field: 'institute_name',
					tdClass: 'text-left  text-primary text-underline',
					thClass: 'text-left'
				},
				{
					label: 'Is verified',
					field: 'is_verified',
				},
				{
					label: 'Type',
					field: 'type',
				},
				{
					label: 'City',
					field: 'city',
				},
				{
					label: 'State',
					field: 'state',
				},
				{
					label: '# Total Students',
					field: 'total_students',
					type: 'number',
					tdClass: 'text-left  text-primary text-underline',
					thClass: 'text-left'
				},
				{
					label: 'Edit',
					field: 'edit',
				},
			],
			duplicateinstitute: false,
			loading: false,
		};
	},
	mounted(){
		this.getInstitutes();
	},
	methods:{
		getInstitutes(){
			this.loading = true;
			this.axios.get('/api/admin/index')
				.then(resp =>{
					this.instituteRows=resp.data.success.institutes;
				});
		},
		handleSubmit: function () {
			this.validateInput('institute_name').then(valid => {
				if (valid) {
					this.saveinstitute();
				}
			});
		},
		saveinstitute(){
			this.axios.post('/api/save-institute',{form_data:this.form_data})
				.then((response) => {
					window.location.href = '/admin/institute/' + response.data.success.institute_id;
					this.closeModal();
				}).catch((err) => {
					if ( 422 === err.response.status ) {
						this.duplicateinstitute = true;
					}
				});
		},
		addNewInstitute(){
			this.edit_institute= {
				youtube_vedio_url:'',
				insta_url:'',
				twitter_url:'',
				fb_url:'',
				linkedin_url:'',
				website: '',
				address: '',
				city:'',
				state:'',
				moto:'',
			};
		},
		editInstitute(institute){
			this.edit_institute = institute;
		},
		updateInstitute(institute){
			this.instituteRows.unshift(institute);
		},
		closeModal(){
			this.errors.clear();
			this.$refs.cancelButton.click();
		}
	},
};
</script>
