<template>
  <div class="creat_post_card img_der artical_page">
    <div>
      <rich-text-editor
        id="ArticleEditor"
        v-model="content"
      />
      <span class="text-danger">{{ error }}</span>
    </div>
  </div>
</template>
<script>
import RichTextEditor from '../../../components/RichTextEditor';
import EventBus from '../event-bus';

export default {
	components: {
		RichTextEditor
	},
	props: ['newPost'],
	data(){
		return{
			content:this.newPost.article_html_content,
			files:[],
			error:'', 
		};
	},
	computed: {
		postType() {
			return this.$store.state.post.post_type.toLowerCase();
		},
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
	},
	mounted(){
		EventBus.$on('validateStep2',()=>{
			if(this.description){
				this.$store.commit('set_post_article_content',{
					postContent:this.content,
					description:this.description,
				});
				EventBus.$emit('validateWizard',2,true);
			}else{
				this.error='Post content cannot be empty.';
				EventBus.$emit('validateWizard',2,false);
			}
		});
	},
};
</script>
<style scoped>
.creat_post_btn button {
    margin: 5px 0px !important;
    min-width: 40%;
}

.creat_post_btn {
    display: flex;
    align-items: center;
    flex-wrap: wrap-reverse;
    justify-content: space-between !important;
    margin: 15px auto;
}
.creat_post_card {
    padding: 20px;
    width: 100%;
}
button.btn-primary btn-lg span {
    margin: 0px 5px;
}
.creat_post_card .form-control {
    border-radius: 0;
    transform: inherit;
}
</style>
