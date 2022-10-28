<template>
    <div class="nav-tabs d-flex">
        <nav :class="[size === 'large' ? 'tabbed-nav2' : 'tabbed-nav']">
            <div class="tabbed-nav1">

                <ul :class="['nav tabbed-nav-list d-flex m-2', align]">
                    <li v-for="tab in tabs" :key="tab" class="nav-item py-.5">
                        <a ref="tabNav" :href="'#' + tab.replace(/ /g, '-')"
                            class="nav-link px-8 py-3 text-slate-500 font-medium text-lg rounded-t-md hover:bg-slate-100 "
                            :class="{active: activeTab === tab,
                              'text-light-gray1':
                                disableTab.indexOf(tab) !== -1
                            }" @click="switchTab(tab, $event)">
                            <slot :name="'tab-heading-' + tab">{{ tab }} </slot>
                        </a>
                    </li>
                </ul>
            </div>

            <div v-for="tab in tabs" :id="tab.replace(/ /g, '-')" :key="tab" class="tab-content">
                <div :class="['tab-pane', tab === activeTab ? 'active' : '']">
                    <slot :name="'tab-panel-' + tab" />
                </div>
            </div>
        </nav>
    </div>
</template>
<style>
.nav-link.active {
    color: #2563eb;
    border-bottom: 3px solid #2563eb;
}

.nav-link.active:hover {
    background-color: #e0f2fe;
}
</style>

<script>
export default {
    props: {
        initialTab: {
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
        },
        align: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            activeTab: ''
        };
    },
    watch: {
        page(val) {
            if (this.tabs.includes(this.initialTab)) {
                this.activeTab = this.initialTab;
            }
        },
        initialTab(val) {
            if (this.tabs.includes(val)) {
                this.activeTab = val;
            }
        }
    },
    mounted() {
        let hash_tab = window.location.hash;
        hash_tab = hash_tab ? hash_tab.replace('#', '') : '';
        if (hash_tab && this.tabs.includes(hash_tab)) {
            this.activeTab = hash_tab;
        } else if (this.tabs.includes(this.initialTab)) {
            this.activeTab = this.initialTab;
        } else {
            this.activeTab = this.tabs[0];
        }
    },
    methods: {
        switchTab(tabName, event) {
            this.$emit('changeTab', tabName);
            this.activeTab = tabName;
            event.target.blur();
            if (window.innerWidth >= 768) {
                event.preventDefault();
            }
        }
    }
};
</script>