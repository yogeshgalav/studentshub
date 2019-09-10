<template>
      <sidebar-menu :menu="menu" :width="'250px'"/>
</template>

<script>
import { SidebarMenu } from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

export default {
  components: {
    SidebarMenu
  },
   data() {
        return {
            menu: [
                // {
                //     header: true,
                //     title: 'Main Navigation',
                //     hiddenOnCollapse: true
                // },
                {
                    header: true,
                    href: '/',
                    title: 'Home',
                    icon: 'fa fa-home',
                },
                // {
                //     href: '/charts',
                //     title: 'Charts',
                //     icon: 'fa fa-chart-area',
                //     child: [
                //         {
                //             href: '/charts/sublink',
                //             title: 'Sub Link'
                //         }
                //     ]
                // }
            ]
        }
    }
}
</script>
