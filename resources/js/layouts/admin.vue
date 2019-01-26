<template>
  <div class="main-layout">
    <navbar-full-width/>
    <sidebar-menu :menu="menu" :collapsed="menuCollapsed" @collapse="menuCollapse" />

    <div class="container mt-4">
      <child/>
    </div>
    <notifications></notifications>
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
          href: {name: 'admin.dashboard'},
          title: {translate: 'dashboard'},
          icon: 'tachometer-alt'
        },
        {
          href: {name: 'admin.users'},
          title: {translate: 'users'},
          icon: 'user'
        },
        {
          href: {name: 'admin.content'},
          title: {translate: 'content'},
          icon: 'user'
        },
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