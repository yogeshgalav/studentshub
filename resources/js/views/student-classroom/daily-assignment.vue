<template>
<div id="no-copy">

</div>
</template>
<style scoped>
      #no-copy {
        user-select: none;
      }
      #no-copy::selection {
        background: none;
      }
      #no-copy::-moz-selection {
        background: none;
      }
</style>
<script>
export default {
    mounted(){
        var target = document.getElementById("no-copy");
        
        // PREVENT CONTEXT MENU FROM OPENING
        target.addEventListener("contextmenu", function(evt){
          evt.preventDefault();
        }, false);
 
        // PREVENT CLIPBOARD COPYING
        target.addEventListener("copy", function(evt){
          // Change the copied text if you want
          evt.clipboardData.setData("text/plain", "");
          // Prevent the default copy action
          evt.preventDefault();
        }, false);
    }
}
</script>