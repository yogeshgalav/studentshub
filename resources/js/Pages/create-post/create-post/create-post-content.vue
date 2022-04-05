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
	props: ['post'],
	data(){
		return{
			content:this.post.html_content,
			files:[],
			error:'', 
		};
	},
	computed: {
		textContent(){
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
		EventBus.$on('validateStep1',()=>{
			if(this.textContent){
				this.$emit('setPostContent',{
					content:this.content,
					text_content:this.textContent,
				});
				EventBus.$emit('validateWizard',1,true);
			}else{
				this.error='Post content cannot be empty.';
				EventBus.$emit('validateWizard',1,false);
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
