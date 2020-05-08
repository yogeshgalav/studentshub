import Vue from 'vue';
import utils from '../helpers/utilities'
Vue.prototype.$utils = utils

//Dependencies
import axios from 'axios'
import VueAxios from 'vue-axios'
import VModal from 'vue-js-modal'

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload);

// or with options
Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: 'dist/error.png',
  loading: 'dist/loading.gif',
  attempt: 1
})
Vue.use(VModal, { dynamic: true, injectModalsContainer: true })
Vue.use(VueAxios, axios);

Vue.mixin({
    components:{
        Loading
    },
    data(){
        return {
            explore_search:'',
        };
    },
    methods: {
        '$trans':function(file,string,defaultString){
            return window.lang[file][string] ? window.lang[file][string] : (defaultString ? defaultString : string);
        },
        redirectPostView(post){
            document.title = post.heading;
        },
        bottomVisible() {
            const scrollY = window.scrollY
            const visible = document.documentElement.clientHeight
            const pageHeight = document.documentElement.scrollHeight
            const bottomOfPage = visible + scrollY >= pageHeight
            return bottomOfPage || pageHeight < visible
          },
          exploreSearch(){
            let path=`/explore`;
            if(!this.explore_search){
                return false;
            }else if(this.$route.path !== path){
                this.$router.replace({ path: '/explore', 'query':{'search':this.explore_search}});
            }else{
                this.$store.dispatch('common/getSearchPageContent',this.explore_search);
            }
          }
    },
    computed: {
        baseUrl() {
            return window.App.baseUrl;
        },
        fileUrl() {
            return window.App.fileUrl;
        },
        signedIn(){
            return window.App.signedIn;
        },
        AuthUser(){
            return window.App.AuthUser;
        },
        AuthUserType(){
            return window.App.AuthUserType;
        },
        csrfToken() {
            return window.App.csrfToken;
        },
        accessToken() {
            return localStorage.getItem('access_token');
        },
    },
    mounted(){
        window.axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization' : "Bearer "+this.accessToken,
        };
    }
});

export default Vue;