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
        }
}
</script>