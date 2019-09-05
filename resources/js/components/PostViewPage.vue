<template>
<section class="pt-100">
<div class="container ptb-50">
    <div class="row">
        <div class="col-md-12 text-center">
            <h4 class="weight-400">Best design resources this week</h4>
            <h2 class="weight-600">A guide for learning spanish in college</h2>
            <div class="avatar mt-3 mb-2">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<h5 class="username weight-600">User Name  | <span class="date text-muted weight-400 text-light-gray1">20 July 2019</span> </h5>
										</div>
        </div>
        </div>
        <div class="col-md-12">
<div class="row justify-center">
    <div class="col-md-1">
        <i class="far fa-comment-alt"></i>
        <span class="badge-text">200</span>
    </div>
    <div class="col-md-1">
        <i class="fas fa-eye"></i>
        <span class="badge-text">2.3 K</span>
    </div>
    <div class="col-md-1">
        <i class="fas fa-heart"></i>
        <span class="badge-text">250</span>
    </div>
</div>
        </div>
    </div>
<category-filter></category-filter>
<div class="container ptb-50">
    <div class="row">
        <div class="col-md-9">
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
            <p>Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.Vestibulum feugiat turpis nec leo pellentesque.</p>
            </div>
            <div class="col-md-3">
                <recent-post></recent-post>
                </div>
        </div>
    </div>
<site-footer></site-footer>
</section> 
</template>
<script>
import CategoryFilter from '../components/CategoryFilter';
import RecentPost from '../components/RecentPost';
import SiteFooter from '../components/SiteFooter';
export default {
    components: 
    {
        CategoryFilter, RecentPost, SiteFooter
    },
}
</script>
