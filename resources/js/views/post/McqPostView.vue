<template>
    <div class="post_s_c">
                            <div class="right_answer">
                                <ul>
                                    <li>{{postContent.optionA}}</li>
                                    <li>{{postContent.optionB}}</li>
                                    <li>{{postContent.optionC}}</li>
                                    <li>{{postContent.optionD}}</li>
                                </ul>
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
</style>
<script>
export default {
    props:['postContent']
}
</script>