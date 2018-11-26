<template>
  <div class="main-layout">
    <navbar-full-width/>
    <sidebar-menu :menu="menu" :collapsed="menuCollapsed" @collapse="menuCollapse" />

    <div class="container mt-4">
      <child/>
    </div>
  </div>
</template>

<script>
  import NavbarFullWidth from "../components/NavbarFullWidth";
  import SidebarMenu from '../components/sidebar-menu/SidebarMenu';

  export default {
    name: 'AdminLayout',

    components: {
      NavbarFullWidth,
      SidebarMenu
    },

    data: () => ({
      menu: [
        {
          href: {name: 'admin.index'},
          title: 'Dashboard',
          icon: 'user'
        },
        {
          href: 'dd',
          title: 'Dashboard',
          icon: 'user',
          disabled: true
        },
        {
          href: {name: 'home'},
          title: 'Dashboard',
          icon: 'user',
          disabled: true
        },
        {
          href: {name: 'home'},
          title: 'Dashboard',
          icon: 'user',
          disabled: true
        },
        {
          href: {name: 'home'},
          title: 'Dashboard',
          icon: 'user',
          disabled: true
        },
        {
          href: {name: 'home'},
          title: 'Dashboard',
          icon: 'user',
          disabled: true
        },
        {
          href: {name: 'home'},
          title: 'Dashboard',
          icon: 'user',
          disabled: true
        },
        {
          title: 'Charts',
          icon: 'chart-area',
          child: [
            {
              href: {name: 'settings.profile'},
              title: 'Dashboard2'
            },
            {
              href: {name: 'settings.profile'},
              title: 'Dashboard2'
            },
            {
              href: {name: 'settings.profile'},
              title: 'Dashboard2'
            },
            {
              href: {name: 'settings.profile'},
              title: 'Dashboard2'
            },
            {
              href: {name: 'settings.profile'},
              title: 'Dashboard2',
              child: [
                {
                  href: {name: 'settings.profile'},
                  title: 'Dashboard2'
                },
                {
                  href: {name: 'settings.profile'},
                  title: 'Dashboard2'
                },
                {
                  href: {name: 'settings.profile'},
                  title: 'Dashboard2'
                }
              ]
            }
          ]
        }
      ]
    }),

    computed: {
      menuCollapsed() {
        return this.$store.getters['interface/menuCollapsed']
      }
    },

    methods: {
      menuCollapse(collapsed) {
        this.$store.dispatch('interface/saveMenuCollapsed', collapsed)
      }
    }
  }
</script>
