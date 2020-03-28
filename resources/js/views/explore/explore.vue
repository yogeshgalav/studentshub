<template>
    <main>
        <div class="container pt-100">
            <div class="col-md-8 center-col">
        <div class="row">
            <div class="col-md-12">
                 <search-post-container></search-post-container>   
            </div>
        </div>
                </div>
            </div>
       
    </main>
</template>
<style scoped>
    .main-habit-builder {
        margin: auto;
    }

    .main-habit-builder .btn-default {
        background: #fff !important;
        box-shadow: 2px 2px 2px #bbbbcc;
        border: 1px solid #eee;
        font-size: 17px;
        font-family: Arial, Helvetica, sans-serif;
        color: #bbbbcc !important;
        font-weight: bold;
        margin-right: 20px;
        margin-bottom: 5px;
    }
    .share{
        position:fixed;
        z-index: 999;
    }
    .main-habit-builder input {
        color: #bbbbcc;
    }

    .main-habit-builder .card {
        padding: 20px !important;
    }

    .main-habit-builder h2 {
        font-size: 36px;
        font-weight: 600;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
    }

    .main-habit-builder p {
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
        margin: 2px 0px 2px 0px;
    }
</style>

<script>
import SearchPostContainer from '../post-containers/SearchPostContainer';
import CategoryFilter from '../category/CategoryFilter';

import {mapState} from 'vuex';

export default {
        components:{
        SearchPostContainer,CategoryFilter
    },
    mounted(){
        this.$store.dispatch('explore/getExplorePageContent',this.$route.query.search);
    },
    methods: {
        trans: function (string, defaultString) {
            return this.$trans('home', string, defaultString);
        },
    },
}
</script>
