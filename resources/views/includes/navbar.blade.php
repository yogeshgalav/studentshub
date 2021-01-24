<div class="container">
    
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="logo">
    <a href='/'>
                <img src="{{asset('/images/logo.png') }}" alt="Student'sHUB"/>
    </a>
</div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav menu_head dash_search">
      <li class="nav-item  search_box ">
      @include('includes.search-form')
      </li>
    <li >
    <div class="mr-2">
  <notifications-dropdown></notifications-dropdown>
  </div>
</li>
      <li class="nav-item">
        @include('includes.profile-dropdown')
      </li>
    </ul>
  </div>
 
</nav>
</div>
