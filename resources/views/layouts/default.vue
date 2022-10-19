<script  lang="ts">
// This is a persistent layout
// Include me with <template layout="default" />
import { defineComponent } from 'vue'

export default defineComponent({
	setup() {
		function toggleSidebar(e) {
			e.preventDefault();
			var sidebar_section = document.getElementById('sidebar-section');
			if (!sidebar_section) {
				return false;
			}
			// console.log("dkshfkjahufhjnfo");

			sidebar_section.classList.toggle('sidebar-section-active');
		}
		return { toggleSidebar };

		// const hamburger = document.querySelector("#hamburger");
		// const navMenu = document.querySelector("#nav-menu");

		// hamburger.addEventListener("click", () => {
		// 	hamburger.classList.toggle("active");
		// 	navMenu.classList.toggle("active");

		// })

		// document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
		// 	hamburger.classList.remove("active");
		// 	navMenu.classList.remove("active");
		// }))
	},
})

</script>

<style>
	@media(max-width:786px){
		.hamburger{
			display: block;

		}
		.hamburger.active .bar:nth-child(2){
			opacity: 0;
		}
		.hamburger.active .bar:nth-child(1){
			transform: translateY(8px) rotate(45deg);
		}
		.hamburger.active .bar:nth-child(3){
			transform: translateY(-8px) rotate(-45deg);
		}

		.nav-menu{
			position: fixed;
			left: -100%;
			top: 70px;
			gap: 0;
			flex-direction: column;
			background: #fff;
			text-align: left;
			transition: 0.3s;
		}
		.nav-item{
			margin: 16px 0;
		}
		.nav-menu.active{
			left: 0;
		}
	}
</style>

<template>
	<div class="w-100% min-h-screen bg-slate-100">
		<header class="w-full bg-white">
			<!-- <nav class=" d-flex flex-wrap md:items-center shadow-md lg:px-16 px-6 bg-white md:py-3 py-3">
				<div class="flex-1 d-flex justify-between items-center text-2xl z-2">
					<a href="#">MyLogo
					</a>
				</div>

				<div class="d-flex flex-col md:items-center md:w-auto" id="sidebar-section">
					<ul
						class=" text-base text-gray-900 pt-8 pl-4 left-0 w-full z-[-1] bg-white md:z-auto md:flex md:items-center md:justify-between md:pt-0 md:static absolute md:opacity-100 opacity-0 top-14 transition-all ease-in duration-700">
						<li><a class="btn" href="#">Home</a></li>
						<li class="dropdown"><a class="btn">
								<div class="flex md:items-center">
									<div class="pr-2">Dropdown</div>
									<svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 20 20">
										<path
											d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
									</svg>
								</div>
							</a>
							<div
								class="dropdown-menu absolute w-36 bg-white rounded divide-y divide-gray-100 shadow hidden text-gray-700">
								<ul class=" text-center ">
									<li><a class="wrap block rounded-t  py-2 px-4 hover:border-blue-600 hover:border-b-2 hover:bg-slate-100"
											href="#">Subitem1</a></li>
									<li><a class="wrap block py-2 px-4 hover:border-blue-600 hover:border-b-2 hover:bg-slate-100"
											href="#">Subitem2</a></li>
									<li><a class="wrap block py-2 px-4 hover:border-blue-600 hover:border-b-2 hover:bg-slate-100"
											href="#">Subitem3</a></li>
									<li><a class="wrap block rounded-b py-2 px-4 hover:border-blue-600 hover:border-b-2 hover:bg-slate-100"
											href="#">Subitem4</a></li>
								</ul>
							</div>
						</li>
						<li><a class="btn" href="#">Item2</a></li>
						<li><a class="btn" href="#">Item3</a></li>
						<div class=" hidden md:flex md:flex-row">
						<input
							class="md:py-1 md:px-4 border rounded-l hover:border-blue-700 focus:outline-none focus:border-blue-700 ml-2 "
							type="text" placeholder="Search....">
						<button
							class="d-flex items-center justify-center px-4 border rounded-r text-gray-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:border-blue-700">
							<svg class="h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 24 24">
								<path
									d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" />
							</svg>
						</button>
					</div>
					</ul>

					<button class="md:hidden py-2 px-2 rounded focus:outline-none hover:bg-gray-100 " id="nav-toggle" @click="toggleSidebar($event)">
						<div class="w-5 h-1 bg-gray-700 mb-1"></div>
						<div class="w-5 h-1 bg-gray-700 mb-1"></div>
						<div class="w-5 h-1 bg-gray-600 "></div>
					</button>
				</div>
			</nav> -->
			<nav id="" class="navbar flex justify-between items-center px-6 py-4">
				<a href="#" id="logo" class="text-2xl">MyLogo</a>

				<ul id="" class=" nav-menu flex justify-between items-center gap-14">
					<li class="nav-item">
						<a href="" class="btn">Home</a>
					</li>
					<li class="nav-item">
						<a href="" class="btn">Item1</a>
					</li>
					<li class="nav-item">
						<a href="" class="btn">Item2</a>
					</li>
				</ul>
				<div id="" class=" hamburger md:hidden cursor-pointer">
					<span class="bar block w-[25px] h-[3px] my-1 mx-auto transition-all ease-in-out duration-[0.3s] "></span>
					<span class="bar block w-[25px] h-[3px] my-1 mx-auto transition-all ease-in-out duration-[0.3s] "></span>
					<span class="bar block w-[25px] h-[3px] my-1 mx-auto transition-all ease-in-out duration-[0.3s] "></span>
				</div>
			</nav>
		</header>
		<section id="main">
			<section id="sidebar"></section>

			<section id="content">
				<slot />
			</section>

			<aside></aside>
		</section>
		<footer>Footer Component</footer>
	</div>
</template>
