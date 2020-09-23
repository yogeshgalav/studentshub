<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header />
    <div class="mt-2">
      <add-button
        name="Add Unit"
        @submit="addUnit"
      />
    </div>
    <div
      v-for="(unit,index) in unitData"
      :key="index"
      class="card mt-5"
    >
      <div>
        <div class="row">
          <div class="col-md-12">
            <accordion
              :title="'Unit '+unit.unit_no+': '+unit.unit_name"
              :aria-expanded="true"
              tab="accordion_status_unit_active"
            >
              <div class="row add_cl_q">
                <div class="col-md-3 col-12">
                  <div class="form-group pl-0">
                    <label
                      class="text-black mb-1"
                      :for="'unit_name' + index"
                    >{{ 'Unit Name' }}</label>
                    <input
                      :id="'unit_name' + index"
                      v-model="unit.unit_name"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      :name="'unit_name' + index"
                      @blur="updateUnitName(unit.unit_no,$event)"
                    >
                    <span class="error">{{ formErrors('unit_name' + index) }}</span>
                  </div>
                </div>
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
			showLoader:true,
			unitData: [],
		};
	},
	computed:{
		latestUnit(){
			return this.unitData.length ? this.unitData[0].unit_no : 0;
		},
	},
	mounted() {
		this.getUnitDetails();
	},
	methods: {
		getUnitDetails(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/unit-details').then((resp) => {
				this.unitData = resp.data.success.unitData;
				this.showLoader=false;
			});
		},
		addUnit() {
			this.unitData.unshift({
				'unit_no': this.latestUnit + 1,
				'unit_name': '',
			});

		},
		updateUnitName(unit_no,event) {
			//call api and update field
			this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/update-unit',{
				unit_no: unit_no,
				unit_name: event.target.value
			});
		}
	}
};

</script>
