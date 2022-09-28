<template>
	<div class="container max-w-full bg-slate-100">
		<div class="mx-auto flex max-w-screen-sm flex-col justify-center lg:max-w-full lg:flex-row">
			<div class="my-2 h-auto w-full rounded-md bg-white shadow-lg lg:my-4 lg:w-2/4">
				<div><img class="rounded-t-md"
						src="https://res.cloudinary.com/practicaldev/image/fetch/s--m8NUlZkW--/c_imagga_scale,f_auto,fl_progressive,h_420,q_auto,w_1000/https://dev-to-uploads.s3.amazonaws.com/uploads/articles/t26phcsxkmy7a4dpd6oi.png"
						alt="" /></div>
				<div class="mx-8 my-6 flex flex-col">
					<div class="flex flex-row">
						<img class="h-12 w-12 rounded-full"
							src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
							alt="" />
						<div class="mx-4 flex flex-col">
							<a href="http://">
								<div class="font-bold text-gray-700 hover:text-indigo-800">Jack</div>
							</a>
							<p class="text-sm text-slate-700">Posted on sep 24</p>
						</div>
					</div>
					<div class="ml-16">
						<a href="#" class="hover:text-indigo-800">
							<div class="mt-4 text-4xl font-bold lg:text-5xl">9 Ways to Reduce Android App Size During
								Android App Development</div>
						</a>
						<div class="mt-3 flex flex-row flex-wrap">
							<a class="mx-2 ml-0 rounded-lg py-1 px-2 hover:bg-slate-200" href="#">#android</a>
							<a class="mx-2 rounded-lg py-1 px-2 hover:bg-slate-200" href="#">#appsize</a>
							<a class="mx-2 rounded-lg py-1 px-2 hover:bg-slate-200" href="#">#codenewbie</a>
							<a class="mx-2 rounded-lg py-1 px-2 hover:bg-slate-200" href="#">#beginners</a>
						</div>
						<div class="mt-4 flex flex-row items-center">
							<a href="#" class="rounded-full py-1 px-1 hover:bg-indigo-300">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
								</svg>
							</a>
							<div class="ml-4 mr-16 font-semibold">Likes</div>
							<a href="#" class="rounded-full py-1 px-1 hover:bg-red-300">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
								</svg>
							</a>
							<div class="mx-4 font-semibold">Comment</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
	setup() {

	},
})
</script>