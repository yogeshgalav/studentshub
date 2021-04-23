<template>
  <div>
    <classroom-header />
    <div class="row">
      <div class="col-md-12">
        <div class="mt-2">
          <div
            class="card"
          >
            <div class="card-body">
              <div class="col-md-12">
                <p>
                  {{ 'Comming soon.' }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>

</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import Accordion from '../../components/accordion';
import AddButton from '../../components/AddButton';
import swal from '../../components/swal.js';
import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: {
		Accordion,
		AddButton,
		ClassroomHeader
	},
	mixins:[FormMixin],
	data() {
		return {
			unitData: [],
			activated_unit:null,
		};
	},
	computed:{
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		}
	},
	mounted() {
		this.getUnitDetails();
	},
	methods: {
		getUnitDetails(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/unit-assignment-details').then((resp) => {
				this.unitData = resp.data.success.unitData;
				this.activate_unit=this.classroomDetail.activated_unit;
			});
		},
		activateUnit(unit_no) {
			let activation_text='';
			if(this.activated_unit===unit_no){
				activation_text='Are you sure you want to Deactivate Unit '+unit_no;
			}else{
				activation_text='Are you sure you want to Activate Unit '+unit_no;
				activation_text += (this.activated_unit ? 'and Deactivate Unit '+this.activated_unit : '');
			}
			activation_text += ' ?';

			swal
				.confirmDialog(activation_text)
				.then(result => {
					if (result.value) {
						this.axios.post('/api/classroom/'+this.classroomDetail.id+'/activate-unit',{
							unit_no: unit_no
						}).then((resp)=>{
							this.activated_unit = resp.data.success.activated_unit;
						});
					}
				});
		},
		addQuestion(unit_no) {
			let unit = this.unitData.find(node=>node.unit_no === unit_no);
			unit.descriptive_questions.push({
				'question_text': '',
				'answer_type': ''
			});
		},
		addOrUpdateQuestion($event,unit_no){

		},
		removeQuestion($event,unit_no){

		}
	}
};

</script>
