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
        <a
          href="#"
          data-toggle="modal"
          data-target="#myModal"
          class="btn btn-primary mt-3 text-white"
        >{{ 'Create new Institute' }}</a>
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
            <div class="col-md-12 client_list">
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
                :columns="clientColumns"
                :rows="clientRows"
              >
                <template
                  slot="table-row"
                  slot-scope="props"
                >
                  <span v-if="props.column.field==='client_name'">
                    <a
                      :href="'/admin/institute/'+props.row.client_id"
                      class="text-underline"
                    >{{ props.row.client_name }}</a>
                  </span>
                  <span v-else>{{ props.row[props.column.field] }}</span>
                </template>
              </vue-table-component>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      id="myModal"
      ref="myModal"
      class="modal fade"
      role="dialog"
    >
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header pt-3 pb-2">
            <h4 class="weight-800 font-size-18">
              {{ 'Create new Institute' }}
            </h4>
          </div>
          <div class="modal-body add-client">
            <form
              class="text-left mb-3"
              @submit.prevent="handleSubmit"
            >
              <div class="form-group p-0">
                <label
                  for="add_client"
                  class="col-form-label mb-0"
                >{{ 'Institute name' }}</label>
                <input
                  id="add_client"
                  v-model="form_data.client_name"
                  v-validate="'required'"
                  name="client_name"
                  class="form-control"
                  autofocus
                >
                <span class="error">{{ formErrors('client_name') }}</span>
                <span
                  v-if="duplicateClient"
                  class="error"
                >{{ 'duplicate institute' }}</span>
              </div>
              <button
                class="btn btn-primary mt-3"
                type="submit"
              >
                {{ 'Create' }}
              </button>  <button
                ref="cancelButton"
                type="button"
                class="btn btn-white mt-3"
                data-dismiss="modal"
                @click.prevent="closeModal"
              >
                {{ 'Cancel' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
    .add-client .btn
    {
        padding: 8px 30px;
    }
</style>
<style>
    .client_list table.table tbody tr td:first-child,
    .client_list table.table  tr th:first-child {
        width: 280px !important;
    }
    .client_list table.table  tr th:nth-child(2),
    .client_list table.table tbody tr td:nth-child(2) {
        width: 200px !important;
    }
</style>
<script>
import VueTableComponent from '../../components/vue-table-component';
import FormMixin from '../../components/mixins/form-mixin.js' ;
import Loading from 'vue-loading-overlay';
import StaffLayout from '@/Layouts/StaffLayout';

export default {
	layout:StaffLayout,
	components: {
		VueTableComponent,
		Loading
	},
	mixins: [FormMixin],
	data(){
	    return {
			form_data:{client_name:'',language:'en-US'},
			clientRows: [],
			clientColumns: [
				{
					label: 'Institute',
					field: 'client_name',
					tdClass: 'text-left  text-primary text-underline',
					thClass: 'text-left'
				},
				{
					label: '# Total Users',
					field: 'total_users',
					type: 'number',
					tdClass: 'text-left  text-primary text-underline',
					thClass: 'text-left'
				},
				{
					label: '# Teachers',
					field: 'teacher_count',
					type: 'number',
					tdClass: 'text-left  text-primary text-underline',
					thClass: 'text-left'
				},
				{
					label: '# Classroom',
					field: 'classroom_count',
					type: 'number',
					tdClass: 'text-left  text-primary text-underline',
					thClass: 'text-left'
				},
			],
			duplicateClient: false,
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
					let rows=[];
					this.clientRows=resp.data.success.institutes.map(node=>{
						let new_node={};
						new_node.client_id=node.id;
						new_node.client_name=node.name;
						new_node.total_users=node.user_count;
						new_node.teacher_count=node.teacher_count;
						new_node.classroom_count=node.classroom_count;
						return new_node;
					}).sort(function (a, b) {
						return ('' + a.client_name).localeCompare(b.client_name);
					});
				}).then(() => {
					this.loading = false;
				}).then(() => {
					this.getFirms();
				}).catch(err => {
					this.loading = false;
				});
		},
		handleSubmit: function () {
			this.validateInput('client_name').then(valid => {
				if (valid) {
					this.saveClient();
				}
			});
		},
		saveClient(){
			this.axios.post('/api/save-institute',{form_data:this.form_data})
				.then((response) => {
					window.location.href = '/admin/institute/' + response.data.success.institute_id;
					this.closeModal();
				}).catch((err) => {
					if ( 422 === err.response.status ) {
						this.duplicateClient = true;
					}
				});
		},
		closeModal(){
			this.errors.clear();
			this.$refs.cancelButton.click();
		}
	},
};
</script>
