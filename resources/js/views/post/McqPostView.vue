<template>
    <div class="post_s_c">
                            <div class="right_answer">
                                <h4> Pick Your Answer</h4>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio" name="option">
                                        <label class="custom-control-label" for="customRadio">{{postContent.optionA}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio1" name="option">
                                        <label class="custom-control-label" for="customRadio1">{{postContent.optionB}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio2" name="option">
                                        <label class="custom-control-label" for="customRadio2">{{postContent.optionC}}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customRadio3" name="option">
                                        <label class="custom-control-label" for="customRadio3">{{postContent.optionD}}</label>
                                    </div>
                                <div class="submit_answer_btn">
                                    <button type="submit">Submit Answer</button>
                                </div>
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
    props:['postContent']
}
</script>