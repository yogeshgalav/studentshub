<template>
    <div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-black">
                        {{ 'Classroom' }}
                    </h1>
                    <p>
                        {{ 'classroom' }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="selection-box-default">
                        <router-link class="card h-card" :to="'/classroom/'+$route.params.classroomId+'/overview'">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="font-size-18">
                                            {{ 'Overview' }}
                                        </h2>
                                        <p>
                                            {{ 'overview' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="selection-box-default">
                        <router-link class="card h-card" :to="'/classroom/'+$route.params.classroomId+'/setup'">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="font-size-18">
                                            {{ 'Setup' }}
                                        </h2>
                                        <p>
                                            {{ 'setup' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
    @import 'resources/sass/_variables.scss';

    .selection-box-default {

        display: flex;
        height: 100%;
        width: 100%;
        min-height: 180px;
    }

    .selection-box-default a {
        width: 100%;
    }

    .selection-box-default .card {
        box-shadow: 0 2px 50px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        border: 4px solid transparent;
        border-radius: 8px;
    }

    .selection-box-default:hover a {
        text-decoration: none;
    }

    .selection-box-default p {
        color: $secondary2-color;
    }

    @media screen and (max-width: 768px) {

        .selection-box-default p,
        .selection-box-default h2 {
            text-align: center;
        }
    }

</style>
<script>
    export default {
        data() {
            return {};
        },
        methods: {

        },
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
    };

</script>
