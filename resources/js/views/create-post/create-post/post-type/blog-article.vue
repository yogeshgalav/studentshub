<template>
  <div>
    <rich-text-editor
      id="ArticleEditor"
      :content.sync="content"
    />
    <span>{{ countContent }}/100</span>&nbsp;<span class="text-danger">{{ error }}</span>
  </div>
</template>
<script>
import RichTextEditor from '../../../../components/RichTextEditor';
import EventBus from '../../event-bus';

export default {
	components:{
		RichTextEditor
	},
	props:['newPost'],
	data(){
		return{
			content:this.newPost.article_html_content,
			files:[],
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
			if(this.countContent>100){
				this.$store.commit('set_post_article_content',{postContent:this.content,description:this.description});
				EventBus.$emit('validateWizard',2,true);
			}else{
				this.error='You must Write Atleast 100 words for an Article.';
				EventBus.$emit('validateWizard',2,false);
			}
		});
	},
};
</script>