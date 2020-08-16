<template>
<div>
  <h2>  {{ title }} </h2>
 <p>
     {{ subtitle }}
      </p>
  </div>
</template>

<script>

export default {
   
   props: {
        title: {
      type: String,
      default: ''
    },
     subtitle: {
      type: String,
      default: ''
    },
   }
}
</script>
