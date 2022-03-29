<template>
  <div class="post_header_single">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 ">
          <a
            class="btn btn-white btn-rounded btn-lg fixed-back"
            @click="goBack"
          ><i class="fa fa-arrow-left" /> Back </a>
        </div>
        <div class="col-md-6">
          <div class="social-network_singlepage">
            <h5 class="social_icon_text">
              Share
            </h5>
            <ul
              v-if="sharetoggle"
              class="social_icon_singlepage social-network social-circle"
            >
              <li>
                <a
                  href="#"
                  class="icoFacebook"
                  title="Facebook"
                  @click="newWindow('https://www.facebook.com/studentshub.in')"
                ><i class="fab fa-facebook-f" /></a>
              </li>
              <li>
                <a
                  href="#"
                  target="_blank"
                  class="icoTwitter"
                  title="Twitter"
                  @click="newWindow('https://www.twitter.com/studentshub_in')"
                ><i class="fab fa-twitter" /></a>
              </li>
              <li>
                <a
                  href="#"
                  target="_blank"
                  class="icoInstagram"
                  title="Instagram"
                  @click="newWindow('https://www.instagram.com/studentshub.in')"
                ><i class="fab fa-instagram" /></a>
              </li>
              <li>
                <a
                  href="#"
                  target="_blank"
                  class="icoLinkedin"
                  title="Linkedin"
                ><i class="fab fa-linkedin" /></a>
              </li>
            </ul>	
          </div>
          <div class="col-md-2 text-right">
            <button
              class="btn btn-white btn-rounded btn-lg"
              @click="sharetoggle=!sharetoggle"
            >
              <i class="fa fa-share-alt" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>

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
.fixed-back
{
    position: fixed;
}


</style>

<script>
export default {
	data()
	{
		return{
			sharetoggle:''
		};
	},
    
};
</script>
