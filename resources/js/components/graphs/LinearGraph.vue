<template>
  <div>
    <div class="col-md-12 mt-2">
      <div class="row">
        <div class="col-md-12 text-center">
          <p class="weight-800 text-black mb-1">
            <span class="font-size-20"> {{ average_score }} </span> <span class="font-size-12 weight-500"> {{ currentRangeSet['gtop'] }}</span>
          </p>
        </div>
      </div>
    </div>
    <div class="row justify-center mb-3">
      <div
        v-if="lowPer"
        class="flex_text pr-2"
      >
        <p class="text-danger font-size-12">
          <span class="bg-danger custom_padding" />  <span class="weight-800"> <span class="pl-2"> {{ lowPer }} % </span> - {{ 'Low' }}  {{ '('+currentRangeSet['rlow']+'-'+currentRangeSet['rtop']+')' }} </span>
        </p>
      </div>
      <div
        v-if="yPresent && medPer"
        class="flex_text pl-2 pr-2"
      >
        <p class="text-warning-dark font-size-12">
          <span class="bg-warning-dark custom_padding" /> <span class="weight-800"> <span class="pl-2">  {{ medPer }} % </span> - {{ 'Medium' }}   {{ '('+currentRangeSet['ylow']+'-'+currentRangeSet['ytop']+')' }}</span>
        </p>
      </div>
      <div
        v-if="highPer"
        class="flex_text pl-2 br-0"
      >
        <p class="text-success font-size-12">
          <span class="bg-success custom_padding" /> <span class="weight-800"> <span class="pl-2"> {{ highPer }} % </span> - {{ 'High' }}  {{ '('+currentRangeSet['glow']+'-'+currentRangeSet['gtop']+')' }}</span>
        </p>
      </div>
    </div>
    <div class="row">
      <div
        v-if="lowPer"
        class="flex bg-danger justify-center"
        :style="'width:'+lowPer+'%'"
      >	
        <span
          v-if="lowPer>5"
          class="text-white"
        > {{ lowPer }} %  </span>
      </div>
      <div
        v-if="yPresent && medPer"
        class="flex bg-warning-dark justify-center"
        :style="'width:'+medPer+'%'"
      >
        <span
          v-if="medPer>5"
          class="text-white"
        > {{ medPer }} %  </span>
      </div>
      <div
        v-if="highPer"
        class="flex bg-success justify-center"
        :style="'width:'+highPer+'%'"
      >
        <span
          v-if="highPer>5"
          class="text-white"
        > {{ highPer }} %  </span>
      </div>
    </div>
  </div>
</template>
<style scoped>
.flex {
  display: flex;
  flex-direction: row;
  height: 25px;
  line-height: 24px;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  border-right:2px solid #fff;
}
.custom_padding {
padding: 2px 9px;
}
.justify-center {
	justify-content: center;
}

.font-size-20 {
  font-size: 20px;
}
.d-block {
	display: block;
}
.weight-bolder {
	font-weight: 1000;
}
.br-0 {
	border-right: 0px !important;
} 
.flex_text {
	border-right: 1px solid #ccc;
	height: 20px;
}
.bg-warning-dark {
	background-color: #F39C12 !important; }
.text-warning-dark {
    color: #F39C12 !important; }
</style>
<script>
export default {
	props: ['rangeData'],
	data(){
		return {
			lowPer:0,
			medPer:0,
			highPer:0,
			average_score:0,
			scaleColorSet:{
				10: {rtop:4,rlow:1,ytop:7,ylow:5,gtop:10,glow:8},
			}

		};
	},
	computed:{
		currentRangeSet(){
			return this.scaleColorSet[this.rangeData[0].range_high];
		},
		yPresent(){
			return this.currentRangeSet['ylow']!==undefined;
		}
	},
	mounted(){
		this.calPercent();
	},
	methods: {
		calPercent(){
			var total_answers=this.rangeData.reduce((a,b)=>{ return a+b.total_answers;},0);
			var sum_of_all_answers=this.rangeData.reduce((a,b)=>{ return a + (b.answer*b.total_answers);},0);
			var low_answers=this.rangeData.reduce((a,b)=>{
				if(parseInt(b.answer)<=this.currentRangeSet['rtop']){
					return a+b.total_answers;
				}
				return a;
			},0);

			var med_answers=this.rangeData.reduce((a,b)=>{
				if(this.currentRangeSet['ylow'] === undefined){
					return a;
				}

				if(parseInt(b.answer)>=this.currentRangeSet['ylow'] && parseInt(b.answer)<=this.currentRangeSet['ytop']){
					return a+b.total_answers;
				}

				return a;
			},0);

			var high_answers=this.rangeData.reduce((a,b)=>{
				if(parseInt(b.answer)>=this.currentRangeSet['glow'] && parseInt(b.answer)<=this.currentRangeSet['gtop']){
					return a+b.total_answers;
				}

				return a;
			},0);

			this.lowPer= Math.round((low_answers/total_answers)*100);
			this.medPer= Math.round((med_answers/total_answers)*100);
			this.highPer= Math.round((high_answers/total_answers)*100);
			let sum = this.lowPer + this.medPer + this.highPer;
			if (sum > 100) {
				this.highPer =  this.highPer-(sum-100);
			}
			this.average_score=parseFloat(sum_of_all_answers/total_answers).toFixed(1);
		}
	}
};
</script>
