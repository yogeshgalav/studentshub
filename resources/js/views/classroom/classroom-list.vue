<template>
    <div>
        <div v-if="myClassrooms.length">
            <p>My Classrooms</p>
            <div v-for="classroom in myClassrooms" :key="classroom.name">
                <a :href="'/classroom/'+classroom.name">{{classroom.name}}</a>
                <p>{{classroom.subject_alias}}</p>
                <p>{{classroom.subject_name}}</p>
                <p>{{classroom.teacher_name}}</p>
            </div>
        </div>
        <div v-if="classroomList.length">
            <p>Followed Classrooms</p>
            <div v-for="classroom in classroomList" :key="classroom.name">
                <a :href="'/classroom/'+classroom.name">{{classroom.name}}</a>
                <p>{{classroom.subject_alias}}</p>
                <p>{{classroom.subject_name}}</p>
                <p>{{classroom.teacher_name}}</p>   
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['myClassrooms','classroomList']
}
</script>