
<template>

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
					<input
                        v-model="content"
                        type="text"
                        class="form-control"
                        name="content"
                      >
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

export default defineComponent({
    setup() {
		const text = ref('');
    },
	data() {
		return {
			heading: '',
			content: '',
			subject_id: '',
            primary_image_url: '',
		};
	},
	mounted(){
		let md1 = new MarkdownIt();
        this.content  = md1.render('# HEading');
	},methods:{
		postCreate() {

					axios.post('/api/post/create', {
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