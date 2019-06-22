<template>
    <main>
        <slot></slot>
        <div class="row main-habit-builder">
            <div class="col-md-8">
                <h2>{{trans('Create new Habit Builder')}}</h2>
                <p class="text-gray">{{trans('Select if you want to use previous Habit Builder as a template or create a new Habit Builder')}}
                </p>
            </div>
            <div class="col-md-6">
                <div class="card h-card" @click="notImplemented">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="icon-left">
                                    <i class="fa fa-paper-plane"></i>
                                </div>

                            </div>

                            <div class="col-md-10">
                                <h3> {{trans('Use Previous Habit Builder as Template')}} </h3>
                                <p class="text-opacity-50">
                                    {{trans('Pre-populated inputs from either previous Habit Builder or system template.')}}
                                </p>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="card h-card" @click="redirect('/habit-builder-wizard/new/')">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="icon-left">
                                    <i class="fa fa-pencil-alt"></i>

                                </div>

                            </div>

                            <div class="col-md-10">
                                <h3> {{trans('Create Habit Builder From Scratch')}} </h3>
                                <p class="text-opacity-50">{{trans('All input field will be blank')}} </p>
                            </div>


                        </div>
                    </div>
                </div>

                <button class="btn-default">Cancel</button>

            </div>
        </div>


    </main>
</template>
<style scoped>

    .main-habit-builder {
        margin: auto;
    }

    .main-habit-builder .btn-default {
        background: #fff !important;
        box-shadow: 2px 2px 2px #bbbbcc;
        border: 1px solid #eee;
        font-size: 17px;
        font-family: Arial, Helvetica, sans-serif;
        color: #bbbbcc !important;
        font-weight: bold;
        margin-right: 20px;
        margin-bottom: 5px;
    }

    .main-habit-builder input {
        color: #bbbbcc;
    }

    .main-habit-builder .card {
        padding: 20px !important;
    }

    .main-habit-builder h2 {
        font-size: 36px;
        font-weight: 600;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
    }

    .main-habit-builder p {
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
        margin: 2px 0px 2px 0px;
    }
</style>

<script>
    export default {
        name: 'HabitBuilderModal',
        data() {
            return {}
        },
        methods: {
            trans: function (string, defaultString) {
                return this.$trans('conversation', string, defaultString);
            },
        },
    }
</script>
