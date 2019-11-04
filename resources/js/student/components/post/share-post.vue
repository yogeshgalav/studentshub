
<template>
<div class="container">
<div class="row">
<div class="col-md-8 center-col">
<div class="card mt-5">
<div class="card-body">
  <form-wizard @on-complete="onComplete">
  <tab-content title="Post Type">
    <select-post-type></select-post-type>
  </tab-content>
  <tab-content title="Create">
    <create-post-content></create-post-content>
  </tab-content>
  <tab-content title="Subject">
    <select-subject></select-subject>
   </tab-content>
   <tab-content title="Heading">
    <select-heading></select-heading>
   </tab-content>
   <!-- <wizard-step 
    slot-scope="props"
    slot="step"
    :tab="props.tab"
    :transition="props.transition"
    :index="props.index">
<label class="label"><span  class="index">
          {{props.index}}
        </span> <span  class="title"></span> <span  class="divider"></span></label>
        </wizard-step> -->
</form-wizard>
</div>
</div>
</div>
</div>
</div>
</template>
<style scoped>

</style>
<script>
import {FormWizard, TabContent, WizardStep} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import SelectPostType from './create-post/select-post-type'
import CreatePostContent from './create-post/create-post-content'
import SelectSubject from './create-post/select-subject'
import SelectHeading from './create-post/select-heading'

export default {
    components: {
  FormWizard,
  TabContent,
  WizardStep,
  SelectPostType,
  CreatePostContent,
  SelectSubject,
  SelectHeading
},
data(){
  return{
  }
},
mounted(){
  this.$store.dispatch('getCategories');
},
methods: {
  onComplete(){
    this.$store.dispatch('submitPost',this.$store.state.new_post).then(this.$router.push('/'));
  }
}
}
</script>
<style scoped>
.label{
  display: flex;
    flex-direction: row;
    align-items: center;
}
.index{
  width: 3.5rem;
    height: 3.5rem;
    display: flex;
    flex-shrink: 0;
    font-size: 1.5rem;
    border-radius: 50%;
    margin-right: 0.5rem;
        align-items: center;
    justify-content: center;
    box-shadow:0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
}
.divider{
      width: 100%;
    margin-left: 0.5rem;
    border-bottom: 1px solid #ffffff;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
        height: 1px;
    border: 1px solid #eee;
    margin-top: 15px;
    margin-bottom: 15px;
}
</style>
