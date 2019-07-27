
<template>
    <form-wizard>
  <tab-content title="Post Type">
    <select-post-type @selectPostType="selectPostType"></select-post-type>
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
</form-wizard>
</template>

<script>
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import SelectPostType from './create-post/select-post-type'
import CreatePostContent from './create-post/create-post-content'
import SelectSubject from './create-post/select-subject'
import SelectHeading from './create-post/select-heading'

export default {
    components: {
  FormWizard,
  TabContent,
  CreatePostContent,
}
}
</script>
