
<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.5.1/katex.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/github-markdown-css/2.2.1/github-markdown.css"/>
	<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-lg-5 card w-96 p-5">
            <div class="h3 text-center ">Post Create</div>
            <form @submit.prevent="postCreate">
                <div class="mb-3 form-group">
                    <label class="mb-1"> {{ 'Heading' }} </label>
					<input
                        v-model="heading"
                        type="text"
                        class="form-control"
                        name="heading"
                      >
                </div>
                <div class="mb-3 form-group">
					<label class="mb-1"> {{ 'Content' }} </label>
					<textarea
                        v-model="content"
                        class="form-control"
                        name="content"
                        v-on:keyup="onChange"
                        rows="10"
                        cols="10"
                      >
                      </textarea>
                </div>
                <label class="mb-1"> {{ 'Result' }} </label>
                <div id="result" style="height:200px; width:320px; background-color: skyblue;">
                    {{ result }}
                </div>
                <div class="mb-3 form-group">
                    <label class="mb-1"> {{ 'Classroom Id' }} </label>
					<input
                        v-model="classroom_id"
                        type="number"
                        class="form-control"
                        name="classroom_id"
                      >
                </div>
                <div class="mb-3 form-group">
                    <label class="mb-1"> {{ 'Image' }} </label>
					<input
                        v-model="primary_image_url"
                        type="text"
                        class="form-control"
                        name="primary_image_url"
                      >
                </div>
                <button type="submit" class="btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</template>
<script lang="ts">
import { defineComponent , ref } from 'vue';
import axios from 'axios';
import MarkdownIt from 'markdown-it';
import MarkdownItSub from 'markdown-it-sub';
import MarkdownItSup from 'markdown-it-sup';
import MarkdownItKatex from 'markdown-it-katex';
import 'markdown-it-latex/dist/index.css';
// import MarkdownItLatex from 'markdown-it-latex';

export default defineComponent({
    setup() {
		
    },
	data() {
		return {
			heading: '',
			content: '',
			subject_id: '',
            primary_image_url: '',
            result:'',
		};
	},
	mounted(){

	},methods:{

        onChange(event){
            const DEFAULT_OPTIONS_LINK_ATTRIBUTES = {
        attrs: {
            target: '_blank',
            rel: 'noopener'
            }
        };
        const DEFAULT_OPTIONS_KATEX = { throwOnError: false, errorColor: '#cc0000' }

        const options =  {markdownIt: {
            linkify: true
          },
          katex: DEFAULT_OPTIONS_KATEX,
          linkAttributes: DEFAULT_OPTIONS_LINK_ATTRIBUTES,}
            let md1 = new MarkdownIt(options).use(MarkdownItSub).use(MarkdownItSup).use(MarkdownItKatex);
            console.log(md1);
            document.getElementById("result").innerHTML = md1.render(this.content);
        },
		postCreate() {

					this.axios.post('/api/post/create', {
						heading: this.heading,
						content: this.content,
						classroom_id: this.classroom_id,
                        primary_image_url: this.primary_image_url,
					}).then(resp=>{
						console.log(resp);
						});

			return true;
		},
	}
})
</script>