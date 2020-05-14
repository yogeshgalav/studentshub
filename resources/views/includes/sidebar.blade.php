
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<div class="primary-nav">

<button class="hamburger open-panel" id="nav-toggle" @click="toggleSidebar($event)">
</button>

<nav role="navigation" class="menu">


  <div class="overflow-container">

    <ul class="menu-dropdown">

      <li><a href="/doubts">Doubts</a><span class="icon"><i class="fas fa-question-circle"></i></span></li>

      <li><a href="/">Home</a><span class="icon"><i class="fa fa-home"></i></span></li>

      <li><a href="/saved-posts">Saved Posts</a><span class="icon"><i class="fas fa-save"></i></span></li>

      <li><a href="/profile">Profile</a><span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span></li>

      <li><a href="/logout">Logout</a><span class="icon"><i class="fa fa-power-off"></i></span></li>

    </ul>

  </div>

</nav>

</div>