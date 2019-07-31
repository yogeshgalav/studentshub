<template>
    <div class="card h-card">
                    <div class="card-header">

                        <div class="row">
                            <input type="text" v-model="heading">
                        </div>
                    </div>
                </div>
</template>
<script>
export default {
    data(){
        return{
            heading:'',
        }
    }
}
</script>
