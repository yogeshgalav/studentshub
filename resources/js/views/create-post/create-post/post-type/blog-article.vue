<template>
  <div>
    <vue-editor
      id="ArticleEditor"
      v-model="content"
      :editor-options="editorSettings"
      :height="'100%'"
    />
    <span>{{ countContent }}/100</span>&nbsp;<span class="text-danger">{{ error }}</span>
  </div>
</template>
<script>

import { VueEditor,Quill } from 'vue2-editor';

import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageResize', ImageResize);
import EventBus from '../../event-bus';

export default {
	components:{
		VueEditor
	},
	props:['newPost'],
	data(){
		return{
			content:this.newPost.article_html_content,
			files:[],
			editorSettings: {
				modules: {
					imageDrop: true,
					imageResize: {},
				}
			},
			error:'', 
		};
	},
	computed:{
		description(){
			if(this.content.trim()===''){
				return '';
			}
			var span= document.createElement('span');
			span.innerHTML= this.content;
        
			var children= span.querySelectorAll('*');
			for(var i = 0 ; i < children.length ; i++) {
				if(children[i].textContent)
					children[i].textContent+= ' ';
				else
					children[i].innerText+= ' ';
			}
			return [span.textContent || span.innerText].toString();
		},
		countContent(){
			return this.description.toString().trim().split(/\s+/).length;
		}
	},
	mounted(){
		EventBus.$on('validateStep2',()=>{
			if(this.countContent()>400){
				this.$store.commit('set_post_article_content',{postContent:this.content,description:this.description});
				EventBus.$emit('validateWizard',2,true);
			}else{
				this.error='You must Write Atleast 400 words for an Article.';
				EventBus.$emit('validateWizard',2,false);
			}
		});
	},
};
</script>