<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 center-col">
                <div class="card mt-5">
                    <div class="card-body">
                        <form @submit.prevent="()=>{}">
                            <form-wizard :step-data="step_data" @onComplete="onComplete"><template slot="header-row" />
                                <template slot="step1">
                                    <select-post-type></select-post-type>
                                </template>
                                <template slot="step2">
                                    <create-post-content></create-post-content>
                                </template>
                                <template slot="step3">
                                    <select-subject></select-subject>
                                </template>
                                <template slot="step4">
                                    <select-heading></select-heading>
                                </template>

                            </form-wizard>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .wizardHeader {
        margin-left: 4rem !important;
    }

    .custom-link .btn {
        padding: 15px 0;
    }

    .vue-form-wizard .wizard-template {
        min-height: 100px;
        padding: 0px 20px 10px;
    }

    .vue-form-wizard .wizard-card-footer {
        background: #FFFFFF;
        box-shadow: 0 -2px 50px rgba(0, 0, 0, 0.15);
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 20px 20% 20px 20%;
        z-index: 300;
        left: 0;
    }

    .wizard-btn {
        border-radius: 3px;
        text-transform: uppercase;
        border: 0 !important;
        padding: 10px 0 10px 0 !important;
    }

    @media only screen and (max-width:768px) {
        .vue-form-wizard .wizard-card-footer {
            background: #FFFFFF;
            box-shadow: 0 -2px 50px rgba(0, 0, 0, 0.15);
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 20px 5% 20px 5%;
            left: 0;
        }

        .vue-form-wizard .wizard-template {
            min-height: 100px;
            padding: 30px 0px 10px;
        }

        .wizardHeader {
            margin-left: 1rem !important;
        }

        .form-control {
            font-size: 16px;
            transform-origin: top left;
            transform: scale(0.75);

        }
    }

</style>
<script>
    import FormWizard from './VueNiceWizard';
    import SelectPostType from './create-post/select-post-type'
    import CreatePostContent from './create-post/create-post-content'
    import SelectSubject from './create-post/select-subject'
    import SelectHeading from './create-post/select-heading'

    import EventBus from './event-bus';

    export default {
        components: {
            FormWizard,
            SelectPostType,
            CreatePostContent,
            SelectSubject,
            SelectHeading
        },
        data() {
            return {
                step_data: [],
                total_steps: 4,
            }
        },
        mounted() {
            for (let i = 1; i <= this.total_steps; i++) {
                this.step_data.push({
                    'backbutton': true,
                    'stepskip': false,
                    'nextTab': true,
                    'validation': true,
                    'emit': '',
                    'name': 'step' + i,
                    'step': i
                });
            }
            this.$store.dispatch('getCategories');
        },
        methods: {
            onComplete() {
                this.$store.dispatch('submitPost', this.$store.state.new_post).then(this.$router.push('/'));
            }
        }
    }

</script>
<style scoped>
    .label {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .index {
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        flex-shrink: 0;
        font-size: 1.5rem;
        border-radius: 50%;
        margin-right: 0.5rem;
        align-items: center;
        justify-content: center;
        box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
    }

    .divider {
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
