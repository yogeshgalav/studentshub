<template>
    <div>
        <slot/>
    </div>
</template>
<script>
export default {
    mounted() {
            if (!this.classroomDetail.id) {
                this.$store.dispatch('classroom/getClassroomDetail',this.$route.params.classroomId);
            }
        },
        computed: {
            classroomDetail() {
                return this.$store.state.classroom.classroomDetail;
            }
        },
        methods:{
            copyText(){
                /* Get the text field */
                var copyText = document.getElementById("copyText");

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /*For mobile devices*/

                /* Copy the text inside the text field */
                document.execCommand("copy");
            }
        }
}
</script>