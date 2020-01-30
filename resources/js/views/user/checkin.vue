
<template>
    <form-wizard>
  <tab-content title="Basic Detail">
    My first tab content
  </tab-content>
  <tab-content title="Education Details">
      My second tab content
   </tab-content>
   <tab-content title="more detail">
     Yuhuuu! This seems pretty damn simple
   </tab-content>
</form-wizard>
</template>

<script>
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

export default {
    components: {
  FormWizard,
  TabContent
}
}
</script>
