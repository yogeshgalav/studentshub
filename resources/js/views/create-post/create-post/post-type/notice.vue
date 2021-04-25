<template>
    <div>
        <vue-editor id="NoticeEditor" v-model="content" :editorOptions="editorSettings" 
        :height="'100%'"/>
        <div class="mt-2">
        <label for="expiry_date">Expiry Date</label>
        <date-picker
            id="expiry_date"
            ref="expiry_date"
            v-validate="'required'"
            name="expiry_date"
            value-type="format"
            v-model="expiry_date"
            :typeable="true"
            :lang="'en'"
            :input-attr="{id: 'event_date_input'}"
            placeholder="Start Year"
        />
        </div>
    </div>
</template>
<script>

import { VueEditor,Quill } from 'vue2-editor'

import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register("modules/imageDrop", ImageDrop);
Quill.register("modules/imageResize", ImageResize);
import DatePicker from 'vue2-datepicker';
import EventBus from '../../event-bus';
import 'vue2-datepicker/index.css';

export default {
    components:{
        VueEditor,DatePicker
    },
    data(){
        return{
            expiry_date:'',
            content:'',
            files:[],
            editorSettings: {
            modules: {
                imageDrop: true,
                imageResize: {},
              }
            } 
        }
    },
    mounted(){
        EventBus.$on('validateStep4',()=>{
			this.$validator.validate().then(valid => {
				if(valid){
                    this.$store.commit('set_post_notice_content',{
                        postContent:this.content,
                        expiry_date:this.expiry_date
                        });
					EventBus.$emit('validateWizard',4,true);
				}else{
					EventBus.$emit('validateWizard',4,false);
				}
			});
		});
    },
}
</script>