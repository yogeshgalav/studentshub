<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"> -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <div class="primary-nav">

<button href="#" class="hamburger open-panel nav-toggle">
</button>

<nav role="navigation" class="menu">


  <div class="overflow-container">

    <ul class="menu-dropdown">

      <li><a href="#">Dashboard</a><span class="icon"><i class="fa fa-home"></i></span></li>

      <li><a href="#">Favourites</a><span class="icon"><i class="fa fa-heart"></i></span></li>

      <li><a href="#">Messages</a><span class="icon"><i class="fa fa-envelope"></i></span></li>

    </ul>

  </div>

</nav>

</div>



<script>
    jQuery(function ($) {
      $('.nav-toggle').click(function(e) {
  
  e.preventDefault();
  $("html").toggleClass("openNav");
  $(".nav-toggle").toggleClass("active");

});




});
</script>