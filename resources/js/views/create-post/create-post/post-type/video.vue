<template>
<div class="video_box">
    <div class="row">
        <div class="col-md-4">
            <div class="video_link form-group">
            <label for="videoLink">Youtube Video Link</label>

            <input type="text" id="videoLink" class="form-control" @blur="embedVideo">
            </div>
             <div v-if="!is_video_embeded" class="video_image">
                <i class="fa fa-video font-size-120 text-light-gray" />
            </div>
            <div v-if="is_video_embeded" class="video_image">
                <iframe :src="video_url" width="320" height="240" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-md-8">
        
        </div>
      
       
    </div>
     <div class="row">
            <div class="col-md-8 mt-2">
                <div class="video_des">
                    <label for="videoDescription">A little Description</label>
                    <textarea id="videoDescription" v-model="video_description" />
                </div>
            </div>
        </div>
</div>   
</template>
<style>
.video_link input {
    width: 100%;
    transform: inherit;
}
.video_image {
    background-color: #ccc;
    /* padding: 50px; */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 240px;
    width: 320px;
    font-size: 60px;
}
.video_des textarea {
    width: 100%;
    border-radius: 5px;
    height: 65px;
}
</style>
<script>

import { mapState } from 'vuex';
import EventBus from '../../event-bus';

export default {
  data(){
    return {
        video_id:'',
        video_url:'',
        video_error:'',
        video_description:'',
        is_video_embeded:false,
    };
  },
  mounted(){
	  EventBus.$on('validateStep2', () => {
        const data = {video_id:this.video_id,description:this.video_description}
        this.$store.commit('set_post_video_content', data);
		  EventBus.$emit('validateWizard',2,true);
	  })
  },
  methods: {
    embedVideo(event){
        let url=event.target.value.trim()+'&';
        this.video_error='';
        this.is_video_embeded=false;

        var regex1 = /(?<=watch\?v\=).*?(?=\&)/gi;
        var regex2 = /(?<=www\.youtu\.be\/).*?(?=\&)/gi;
        var v_id='';
        if(v_id=regex1.exec(url)){
            this.video_id=v_id[0];
        }else if(v_id=regex2.exec(url)){
            this.video_id=v_id[0];
        }else{
            this.video_error='This video link is not supported';
            return false;
        }

        this.video_url='https://www.youtube.com/embed/'+v_id[0];
        this.is_video_embeded=true;
    }
  }
}
</script>