<template>
  <div class="mt-3 mb-2">
    <div class="row justify-center mb-2">
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
	props: ['lowCount','medCount', 'highCount'],
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
			return this.scaleColorSet[10];
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
            let lowestCount = parseInt(this.lowCount);
            let mediumCount = parseInt(this.medCount);
            let highCount = parseInt(this.highCount);
            let totalCount = lowestCount+mediumCount+highCount;
            this.lowPer = Math.floor(lowestCount/totalCount*100);
            this.medPer = Math.floor(mediumCount/totalCount*100);
            this.highPer = Math.floor(highCount/totalCount*100);
            console.log(totalCount);

	    }
    }
};
</script>
