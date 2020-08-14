
<template>
    <doubt-layout>
            <template>
                <modal name="add_doubt_modal" class="doubt_model">
    
        <form @submit.prevent="addDoubt">
            <div class="model_box_inner">
            <div class="row">
                <div class="col-md-12">
                  <p class="model_box_head">  Ask Doubt about concepts which belongs to your Course.
                    Initially this doubt will be shared with students of your batch and course.</p>
                </div>
            <div class="col-md-12">
                <div class="model_input">
                    <label>Doubt</label>
                    <input class="form-control" type="text" placeholder="Enter Your Doubt" v-model="question">
                </div>
            </div>
            <div class="col-md-12">
                <div class="model_input">
                    <label>Subject</label>
                    <input class="form-control" type="text" v-model="subject" placeholder="Enter Your Subject">
                </div>
            </div>
            <div class="col-md-12">
                <div class="model_btn">
                    <button type="submit" class="ask_doubt_btn">submit</button>
                </div>    
            </div>
            </div>
            </div>
        </form>
    
</modal>
            </template>
    </doubt-layout>    
</template>
<script>
import ClassroomLayout from '../layouts/ClassroomLayout.vue'
import DoubtLayout from '../layouts/DoubtLayout.vue'
import VModal from 'vue-js-modal'

    export default {
        components:{
            ClassroomLayout,
            DoubtLayout,
            VModal
        },
        data(){
            return {
                question:'',
                subject:'',
                new_doubt_type:'batch',
            }
        }
    };

</script>