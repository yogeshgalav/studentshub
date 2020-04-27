<template>
    <div class="row">
        <div class="col-md-8">
            <label for="videoLink">Youtube Video Link</label>

            <input type="text" id="videoLink" @blur="embedVideo">
            
        </div>
        <div v-if="!is_video_embeded"
            class="p-5 gray-box text-center mt-3"
            >
            <i class="fa fa-video font-size-120 text-light-gray" />
        </div>
       <div v-if="is_video_embeded" class="p-5 mt-3">
            <iframe :src="video_url" width="320" height="240" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            <span class="text-danger" v-if="video_error">{{video_error}}</span>
        </div>
        <div class="row">
            <div class="col-md-8 mt-2">
                <label for="videoDescription">A little Description</label>
                <textarea id="videoDescription" v-model="video_description" />
            </div>
        </div>
    </div>
</template>
<script>

import { mapState } from 'vuex';
import EventBus from '../../event-bus';

export default {
  data(){
    return {
        video_url:'',
        video_error:'',
        video_description:'',
        is_video_embeded:false,
    };
  },
  mounted(){
	  EventBus.$on('validateStep2', () => {
        const data = {link:this.video_url,description:this.video_description}
        this.$store.commit('set_post_video_content', data);
		  EventBus.$emit('validateWizard',2,true);
	  })
  },
  methods: {
    embedVideo(event){
        let url=event.target.value.trim();
        this.video_error='';
        this.is_video_embeded=false;

        if(url.indexOf('youtube.com')!==-1){
            url = url.replace('https://www.youtube.com/watch?v=','https://www.youtube.com/embed/');
        }else{
            this.video_error='This video link is not supported';
            return false;
        }

        this.video_url=url;
        this.is_video_embeded=true;
    }
  }
}
</script>