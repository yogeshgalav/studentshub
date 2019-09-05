<template>
<div>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h5>Best design resources this week</h5>
            <h2>A guide for learning spanish in college</h2>
            <div class="avatar">
											<img src="/images/4.jpg" alt="..." class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">User NAme</p>
											<p class="date text-muted">20 July 2019</p>
										</div>
        </div>
        </div>
        <div class="col-md-12">
<div class="row">
    <div class="col-md-2">
        <i class="far fa-comment-alt"></i>
        <span class="badge-text">200</span>
    </div>
    <div class="col-md-2">
        <i class="fas fa-eye"></i>
        <span class="badge-text">2.3 K</span>
    </div>
    <div class="col-md-2">
        <i class="fas fa-heart"></i>
        <span class="badge-text">250</span>
    </div>
</div>
        </div>
    </div>
<category-filter></category-filter>
<div class="container">
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
</div> 
</template>
<script>
import CategoryFilter from '../components/CategoryFilter';
import RecentPost from '../components/RecentPost';
export default {
    components: 
    {
        CategoryFilter, RecentPost
    },
}
</script>
