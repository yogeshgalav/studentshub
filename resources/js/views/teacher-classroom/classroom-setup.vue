<template>
    <div>
        <div class="mt-2">
            <add-button name="Add Unit" @submit="addUnit" />
        </div>
        <div class="card mt-5" v-for="(unit,index) in unitData" :key="index">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <accordion :title="'Unit '+unit.unit_no+': '+unit.unit_name" :aria-expanded="true"
                            tab="accordion_status_unit_active">
                            <div class="row add_cl_q">
                                <div class="col-md-3 col-12">
                                    <div class="form-group pl-0">
                                        <label class="text-black mb-1"
                                            :for="'unit_name' + index">{{ 'Unit Name' }}</label>
                                        <input :id="'unit_name' + index" v-model="unit.unit_name" v-validate="'required'"
                                            type="text" class="form-control" :name="'unit_name' + index"
                                            @blur="updateUnitName(unit.unit_no,$event)">
                                        <span class="error">{{ formErrors('unit_name' + index) }}</span>
                                    </div>
                                </div>
                            </div>
                          
                                <div class="mt-5">
                                    <hr />
                                    <button class="btn btn-danger btn-md" @click="deleteUnit(unit.unit_no)"> Delete Unit
                                    </button>
                                    <button class="btn btn-primary btn-md" @click="activateUnit(unit.unit_no)">{{ activated_unit===unit.unit_no ? 'Deactivate Unit' : 'Activate Unit'}}
                                    </button>
                                </div>
                        </accordion>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import FormMixin from '../../components/mixins/form-mixin.js';
    import Accordion from '../../components/accordion';
    import AddButton from '../../components/AddButton';
    import swal from '../../components/swal.js';
    
    export default {
        mixins:[FormMixin],
        components: {
            Accordion,
            AddButton
        },
        data() {
            return {
                unitData: [],
                activated_unit:null,
            };
        },
        computed:{
            latestUnit(){
                return this.unitData.length ? this.unitData[0].unit_no : 0;
            },
            classroomDetail(){
                return this.$store.state.classroom.classroomDetail;
            }
        },
        mounted() {
            if(!this.classroomDetail.id){
                this.$store.dispatch('classroom/getClassroomDetail',this.$route.params.classroomId).then(()=>{
                    this.activate_unit=this.classroomDetail.activated_unit;
                    this.getUnitDetails();
                });
            }else{
                this.getUnitDetails();
            }
        },
        methods: {
            getUnitDetails(){
                this.axios.get('/api/classroom/' + this.classroomDetail.id + '/unit-details').then((resp) => {
                    this.unitData = resp.data.success.unitData
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
            addUnit() {
                this.unitData.unshift({
                    'unit_no': this.latestUnit + 1,
                    'unit_name': '',
                    'questions': []
                });

            },
            deleteUnit(unit_no) {
                swal
				.confirmDialog('Are you sure you want to Delete Unit '+unit_no+'?')
				.then(result => {
					if (result.value) {
						this.axios.post('/api/classroom/'+this.classroomDetail.id+'/delete-unit',{
                            unit_no: unit_no
                        });
                        
                        let deleteIndex = this.unitData.findIndex(node=>node.unit_no===unit_no);
                        this.unitData.slice(deleteIndex,1);
					}
				});
            },
            updateUnitName(unit_no,event) {
                //call api and update field
                this.axios.post('/api/classroom/'+this.classroomDetail.id+'/update-unit',{
                    unit_no: unit_no,
                    unit_name: event.target.value
                });
            }
        }
    }

</script>
