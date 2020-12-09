<template>
<div class="video_box">
    <div class="row">
        <div class="col-md-4">
            <div class="video_link form-group">
            <label for="videoLink">Youtube Video Link</label>

            <input type="text" id="videoLink" name="youtube_video_link" v-validate="'required'" class="form-control" @blur="embedVideo">
            </div>
            <div v-if="is_video_embeded==true" class="video_image">
                <iframe :src="'https://www.youtube.com/embed/'+video_id" width="320" height="240" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
              <!-- <div v-else class="video_image">
                <i class="fa fa-video font-size-120 text-light-gray" />
            </div> 
            -->

        </div>
        <div class="col-md-8">
        
        </div>
      
       
    </div>
     <div class="row">
            <div class="col-md-8 mt-2">
                <div class="video_des">
                    <label for="videoDescription">A little Description</label>
                    <textarea id="videoDescription" v-model="video_description" name="description" v-validate="'required'"/>
                    <span class="text-danger">{{ formErrors('description') }}</span>
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
import FormMixin from "../../../../components/mixins/form-mixin.js";
import { mapState } from 'vuex';
import EventBus from '../../event-bus';

export default {
    props:['newPost'],
    mixins:[FormMixin],
  data(){
    return {
        video_id:this.newPost.video_id,
        video_url:"https://www.youtube.com/embed/",
        video_error:'',
        video_description:this.newPost.video_description,
        is_video_embeded:false,
        is_embeded:false
    };
  },
  updated(){
      console.log(this.is_video_embeded)

  },
  mounted(){
	  EventBus.$on('validateStep2', () => {
          this.$validator.validate().then(valid => {
            if(valid  && this.video_id && this.video_error===''){
                const data = {video_id:this.video_id,description:this.video_description}
                this.$store.commit('set_post_video_content', data);
                EventBus.$emit('validateWizard',2,true);
            }else{
                EventBus.$emit('validateWizard',2,false);
            }
          });
	  })
  },
  methods: {
    embedVideo(event){
      this.video_error='';
        this.is_video_embeded=false;
        let url =event.target.value.trim();
        if(url===''){
            this.video_error='An Youtube video link is required.';
            return false;
        }
        let id = this.matchYoutubeUrl(url);
        console.log(id)
        if(id!==false){
            this.video_id=id;
            this.is_video_embeded=true
            return true
        }else{
            this.video_error='This video link is not supported';
            return false;
        }

        this.is_video_embeded=true;
        console.log(this.is_video_embeded)
    },
    matchYoutubeUrl(url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        var matches = url.match(p);
        
        if(matches){
            return matches[1];
        }
        return false;
    }
  }
}
</script>