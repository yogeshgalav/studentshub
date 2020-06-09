<template>
    <div class="post_s_c">
                            <div class="right_answer">
                                <h4> Pick Your Answer</h4>
                                <form @submit.prevent="showAnswer">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio" name="option" v-model="submitted_answer" :value="1" :disabled="is_submitted">
                                        <label :class="['custom-control-label', optionClass(1) ]" for="customRadio">{{postContent.optionA}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio1" name="option" v-model="submitted_answer" :value="2" :disabled="is_submitted">
                                        <label :class="['custom-control-label', optionClass(2) ]" for="customRadio1">{{postContent.optionB}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio2" name="option" v-model="submitted_answer" :value="3" :disabled="is_submitted">
                                        <label :class="['custom-control-label', optionClass(3) ]" for="customRadio2">{{postContent.optionC}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio3" name="option"  v-model="submitted_answer" :value="4" :disabled="is_submitted">
                                        <label :class="['custom-control-label', optionClass(4) ]" for="customRadio3">{{postContent.optionD}}</label>
                                    </div>
                                    <span class="text-danger" v-if="show_error">Please select an Option.</span>
                                <div class="submit_answer_btn">
                                    <button type="submit" v-if="is_submitted===false">Submit Answer</button>
                                    <button type="button" class="btn btn-success" v-if="is_submitted===true && is_correct===true">Correct Answer</button>
                                    <button type="button" class="btn btn-danger" v-if="is_submitted===true && is_correct===false">Wrong Answer</button>
                                </div>
                                </form>
                            </div>
                            <div v-if="is_submitted">
                                {{postContent.mcq_answer}}
                            </div>
                            </div>
</template>

<style scoped>
.right_answer ul li {
    list-style: none;
    border: solid 1px #ccc;
    color: #868686;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.right_answer ul {
    display: flex;
    justify-content: space-between;
    padding: 0;
    background-color: white;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 5px;
}
.right_active {
    border: solid 1px green;
    background-color: green;
 color: white !important;
}
.right_answer .custom-control.custom-radio {
    margin-bottom: 30px;
}
.right_answer {
    background: white;
    box-shadow: 0 0 10px rgba(0,0,0,0.12);
    padding: 20px 10px;
}
.right_answer h4 {
    font-weight: 600;
    padding: 0 7px 15px;
    color: #868686;
}
.submit_answer_btn button {
    border: none;
    background: #3746c5;
    color: white;
    padding: 8px 20px;
    border-radius: 3px;
    box-shadow: 0 0 10px rgba(0,0,0,0.12);
}
.submit_answer_btn {
    margin: 0 8px;
}

.right_answer .custom-control.custom-radio label {
    color: #868686;
}
</style>
<script>
export default {
    props:['postContent'],
    data(){
        return {
            submitted_answer:'',
            is_submitted:false,
            is_correct:false,
            show_error:false
        };
    },
    methods:{
        showAnswer(){
            this.show_error=false;
            if(this.submitted_answer===''){
                this.show_error=true;
                return false;
            }else if(this.submitted_answer===this.postContent.correct_option){
                this.is_correct=true;
            }else{
                this.is_correct=false;
            }
            this.is_submitted=true;
        },
        optionClass(num){
            if(this.is_submitted===false){
                return '';
            }else if(this.postContent.correct_option===num){
                return 'text-success';
            }else{
                return 'text-danger'
            }
        }
    }
}
</script>