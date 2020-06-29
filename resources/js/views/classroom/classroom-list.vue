<template>
    <div>
        <div class="row">
            <div class="col-md-4">
        <div v-if="myClassrooms.length" class="clas_roo_main_box">
            <div class="cl_box_top">
            <p>My Classroomsb</p>
            </div>
            <div v-for="classroom in myClassrooms" :key="classroom.name" class="classroom_box">
                <a :href="'/classroom/'+classroom.name">{{classroom.name}}</a>
                <p>{{classroom.subject_alias}}</p>
                <p>{{classroom.subject_name}}</p>
                <p>{{classroom.teacher_name}}</p>
            </div>
        </div>
            </div>
            <div class="col-md-4">
        <div v-if="classroomList.length" class="clas_roo_main_box">
            <div class="cl_box_top">
            <p>Followed Classrooms</p>
            </div>
            <div v-for="classroom in classroomList" :key="classroom.name">
                <a :href="'/classroom/'+classroom.name">{{classroom.name}}</a>
                <p>{{classroom.subject_alias}}</p>
                <p>{{classroom.subject_name}}</p>
                <p>{{classroom.teacher_name}}</p>   
            </div>
        </div>
        </div>  
        </div>
    </div>
</template>
<script>
export default {
    props:['myClassrooms','classroomList']
}
</script>

<style>
    .clas_roo_main_box {
    box-shadow: 0 0 10px rgba(0,0,0,0.16);
    border-radius: 4px;
}
    .cl_box_top p {
    color: white;
    font-size: 24px;
    font-weight: 700;
}

.cl_box_top {
    padding: 50px;
    text-align: center;
    background-color: #0f6bff;
    background: linear-gradient(90deg, #020024 0%, #090979 0%, #0475c0 0%, #00d4ff 79%);
}
.classroom_box p {
    color: #868686;
}

.classroom_box a {
    font-size: 20px;
    color: black;
    font-weight: 700;
}
.classroom_box {
    padding: 20px;
}
</style>