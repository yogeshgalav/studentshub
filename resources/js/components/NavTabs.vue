<template>
  <div>
    <nav :class="[size==='large' ?'tabbed-nav2' : 'tabbed-nav', 'mt-3']">
      <div
        class="tabbed-nav1"
      >
        <ul class="nav">
          <li
            v-for="tab in tabs"
            :key="tab"
            class="nav-item"
          >
            <a
              ref="tabNav"
              :href="'#'+ tab.replace(/ /g,'-')"
              class="nav-link"
              :class="{
                'active': activeTab===tab,
                'text-light-gray1': disableTab.indexOf(tab)!==(-1)
              }"

              @click="switchTab(tab, $event);"
            >
              <slot :name="'tab-heading-'+tab">{{ tab }} </slot>
            </a>
          </li>
        </ul>
      </div>
      <div
        v-for="tab in tabs"
        :id="tab.replace(/ /g,'-')"
        :key="tab"
        class="tab-content"
      >
        <div
          :class="['tab-pane',tab===activeTab ? 'active' : '']"
        >
          <slot :name="'tab-panel-'+tab" />
        </div>
      </div>
    </nav>
  </div>
</template>
<style lang="scss">
    @import 'resources/sass/_variables.scss';
    /* Navigation Tabs */
    .tabbed-nav1  ul   {
        border-bottom: 1px solid #000 !important;
    }
    .tabbed-nav ul li a {
        text-align: center;
        color: #000;
        font-weight: 800;
        padding: 6px 60px 6px 60px;
    }
    .tabbed-nav ul li a:focus,.tabbed-nav ul li a:hover {
        background: #deedf9;

    }
    .tabbed-nav .nav-item {
        background: transparent;
        border: 0;
        border-bottom: none;
    }

    // Nav Tab 2
    .tabbed-nav2 .nav-item .active {
        background: #fff;
        border: 1px solid #707070;
        border-bottom: none !important;
        color: #2F80ED !important;
        position: relative;
        margin-bottom: -1px;
    }
    .tabbed-nav2 .nav-item .active:focus {
        background: #deedf9 !important;
        color: #000 !important;
    }
    .tabbed-nav2 .nav {
        padding-left: 10px;
    }
    .tabbed-nav2 .nav-item a {
        text-align: center;
        color: #000;
        font-size: 14px;
        padding: 6px 30px;
        font-weight: 800;
        cursor: pointer;
    }

    .tabbed-nav2 ul li a {
        text-align: center;
        color: #000;
        font-weight: 800;
        padding: 6px 60px 6px 60px;
    }
    .tabbed-nav2 ul li a:focus,.tabbed-nav ul li a:hover {
        background: #deedf9;

    }
    .tabbed-nav2 .nav-item {
        background: $white;
        border: 0;
        border-bottom: none;
    }

    // Nav Tab 1
    .tabbed-nav .nav-item .active {
        background: #fff;
        border: 1px solid #707070;
        border-bottom: none !important;
        color: #2F80ED !important;
        position: relative;
        margin-bottom: -1px;
    }
    .tabbed-nav .nav-item .active:focus {
        background: #deedf9 !important;
        color: #000 !important;
    }
    .tabbed-nav .nav {
        padding-left: 10px;
    }
    .tabbed-nav .nav-item a {
        text-align: center;
        color: #000;
        font-size: 14px;
        padding: 6px 30px;
        font-weight: 800;
        cursor: pointer;
    }
    @media screen  and (max-width: 768px) {
        .tabbed-nav .nav
        {
            position: fixed;
            bottom:0;
            left:0;
            right:0;
            z-index: 1000;
            background: #D9D9D9;

        }
        .tabbed-nav .nav {
            border-bottom: 0 solid #000000 !important;

        }
        .tabbed-nav .nav-item .active {
            background: #fff;
            border: 0 solid #707070;
            border-bottom: none !important;
            color: #000 !important;
            position: static;
            margin-bottom:0;
            font-weight:normal;
        }
        .tabbed-nav  .nav {
            padding-left:0;
        }
        .tabbed-nav .nav-item {
            background: #D9D9D9;
            border: 0;
            border-bottom: none;
            width: 23.33%;
            cursor: pointer;
        }

        .tabbed-nav .nav-item a {
            text-align: center;
            color: #5E5E5E;
            padding: 10px 20px;
            font-weight: 500;
            letter-spacing: 0.002em;
            cursor: pointer;
            word-wrap: break-word;
            min-height: 100%;
        }

        // Nav Tab 2
        .tabbed-nav2 .nav
        {
            position: fixed;
            bottom:0;
            left:0;
            right:0;
            z-index: 1000;
            background: #D9D9D9;

        }
        .tabbed-nav2 .nav {
            border-bottom: 0 solid #000000 !important;

        }
        .tabbed-nav2 .nav-item .active {
            background: #fff;
            border: 0 solid #707070;
            border-bottom: none !important;
            color: #000 !important;
            position: static;
            margin-bottom:0;
            font-weight:normal;
        }
        .tabbed-nav2  .nav {
            padding-left:0;
        }
        .tabbed-nav2 .nav-item {
            background: #D9D9D9;
            border: 0;
            border-bottom: none;
            width: 33.33%;
            cursor: pointer;
        }

        .tabbed-nav2 .nav-item a {
            text-align: center;
            color: #5E5E5E;
            padding: 10px 20px;
            font-weight: 500;
            letter-spacing: 0.002em;
            cursor: pointer;
            word-wrap: break-word;
            min-height: 100%;
        }

        .text-underline
        {
            text-decoration: underline !important;
        }
    }
    @media screen  and (min-width: 1024px) and (max-width:1166px) {
        .tabbed-nav .nav-item a
        {
            padding: 10px 20px;
        }
    }
    @media screen  and (min-width: 392px) and (max-width:460px) {
        .tabbed-nav .nav-item a
        {
            padding: 5px 12px;
            font-size:13px;
            min-height: 100%;
        }
        .tabbed-nav .nav-item{
            width: 23.33%;
        }
        .tabbed-nav2 .nav-item{
            width: 33.33%;
        }
    }
    @media screen  and (min-width: 375px) and (max-width:460px) {
        .tabbed-nav2 .nav-item a
        {
            padding: 10px 10px;
        }

    }
    @media screen  and (max-width: 392px) {
        .tabbed-nav .nav-item a
        {
            padding: 5px 5px;
            font-size:10px;
            min-height: 100%;
        }
        .tabbed-nav .nav-item{
            width: 23.33%;
        }
        .tabbed-nav2 .nav-item{
            width: 33.33%;
        }
    }
</style>
<script>
export default {
	props: {
		initialTab:{
			type: String,
			default: ''
		},
		tabs: {
			type: Array,
			default: () => []
		},
		disableTab: {
			type: Array,
			default: () => []
		},
		size: {
			type: String,
			default: ''
		},
		page: {
			type: String,
			default: ''
		}
	},
	data() {
		return {
			activeTab: '',
		};

	},
	watch:{
		page(val){
			if(this.tabs.includes(this.initialTab)) {
				this.activeTab = this.initialTab;
			}
		},
		initialTab(val){
			if(this.tabs.includes(val)) {
				this.activeTab = val;
			}
		}
	},
	mounted(){
		if(this.tabs.includes(this.initialTab)) {
			this.activeTab = this.initialTab;
		}else{
			this.activeTab=this.tabs[0];
		}
	},
	methods: {
		switchTab(tabName, event){
			this.activeTab = tabName;
			event.target.blur();
			if (window.innerWidth>= 768)
			{
				event.preventDefault();
			}
		},
	}
};
</script>
