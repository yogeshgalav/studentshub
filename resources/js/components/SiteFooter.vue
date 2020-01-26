<template>
    <section class="home-newsletter">
<div class="container">
<div class="row">
<div class="col-sm-12">
	<form class="single" @submit.prevent="subscribe">
		<h2>Subscribe to our Newsletter</h2>
	<div class="input-group">
         <input type="email" class="form-control" placeholder="Enter your email"
		 name="email" 
		 v-model="subscribe_email"
		 v-validate="'email|required'">
         <span class="input-group-btn">
         <button class="btn btn-theme" type="submit">Subscribe</button>
         </span>
          </div>
	</form>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="divider mt-5 mb-3"></div>
    </div>
    <div class="col-md-12 text-center mt-3 mb-3">
                    <ul class="social-network social-circle">
                        <li><a target="_blank" href='https://www.facebook.com/studentshub.in' class="icoFacebook" title="Facebook"><i class="fab fa-facebook"></i></a></li>
                        <li><a target="_blank" href='https://www.twitter.com/studentshub_in'  class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a  target="_blank" href='https://www.instagram.com/studentshub.in' class="icoInstagram" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#" target="_blank" class="icoLinkedin" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                    </ul>				
				</div>
                <div class="col-md-12 text-center">
                    <ul class="foote_bottom_ul_amrc">
<li><a href="#">Home</a></li>
<li><a href="#">About</a></li>
<li><a href="#">Services</a></li>
<li><a href="#">Pricing</a></li>
<li><a href="#">Blog</a></li>
<li><a href="#">Contact</a></li>
</ul>
                    </div>
</div>
</div>
</section>
</template>
<style scoped>
.home-newsletter {
padding: 40px 0;
background: #fff;
}

.home-newsletter .single {
max-width: 650px;
margin: 0 auto;
text-align: center;
position: relative;
z-index: 2; }
.home-newsletter .single h2 {
font-size: 22px;
margin-bottom: 40px; }
.home-newsletter .single .form-control {
height: 50px;
background: rgba(255, 255, 255, 0.6);
border-color: transparent;
border-radius: 20px 0 0 20px;
border:1px solid #eee;
 }
.home-newsletter .single .form-control:focus {
box-shadow: none;
border-color: #243c4f; }
.home-newsletter .single .btn {
min-height: 50px; 
border-radius: 0 20px 20px 0;
background: #10069F ;
color: #fff;
}

/* social media icons  */
ul.social-network {
	list-style: none;
	display: inline;
	margin-left:0 !important;
	padding: 0;
}
ul.social-network li {
	display: inline;
	margin: 0 5px;
}


/* footer social icons */
.social-network a.icoRss:hover {
	background-color: #F56505;
}
.social-network a.icoFacebook:hover {
	background-color:#3B5998;
}
.social-network a.icoTwitter:hover {
	background-color:#33ccff;
}
.social-network a.icoGoogle:hover {
	background-color:#BD3518;
}
.social-network a.icoVimeo:hover {
	background-color:#0590B8;
}
.social-network a.icoLinkedin:hover {
	background-color:#007bb7;
}
.social-network a.icoRss:hover i, .social-network a.icoFacebook:hover i, .social-network a.icoTwitter:hover i,
.social-network a.icoGoogle:hover i, .social-network a.icoVimeo:hover i, .social-network a.icoLinkedin:hover i {
	color:#fff;
}
a.socialIcon:hover, .socialHoverClass {
	color:#44BCDD;
}

.social-circle li a {
	display:inline-block;
	position:relative;
	margin:0 auto 0 auto;
	-moz-border-radius:50%;
	-webkit-border-radius:50%;
	border-radius:50%;
	text-align:center;
	width: 50px;
	height: 50px;
	font-size:20px;
}
.social-circle li i {
	margin:0;
	line-height:50px;
	text-align: center;
}

.social-circle li a:hover i, .triggeredHover {
	-moz-transform: rotate(360deg);
	-webkit-transform: rotate(360deg);
	-ms--transform: rotate(360deg);
	transform: rotate(360deg);
	-webkit-transition: all 0.2s;
	-moz-transition: all 0.2s;
	-o-transition: all 0.2s;
	-ms-transition: all 0.2s;
	transition: all 0.2s;
}
.social-circle i {
	color: #fff;
	-webkit-transition: all 0.8s;
	-moz-transition: all 0.8s;
	-o-transition: all 0.8s;
	-ms-transition: all 0.8s;
	transition: all 0.8s;
}

.social-circle a {
 background-color: #333;   
}

.foote_bottom_ul_amrc {
	list-style-type:none;
	padding:0px;
	display:table;
	margin-top: 10px;
	margin-right: auto;
	margin-bottom: 10px;
	margin-left: auto;
}
.foote_bottom_ul_amrc li { display:inline;}
.foote_bottom_ul_amrc li a { color:#333; margin:0 12px;}
</style>


<script>
import formMixin from './mixins/form-mixin.js'
export default {
	mixins:['formMixin'],
	data(){
		return{
			subscribe_email:'',
		}
	},
    methods:{
		subscribe(){
			this.$store.dispatch('explore/subscribe',{email:this.subscribe_email});
		}
	}
}
</script>

