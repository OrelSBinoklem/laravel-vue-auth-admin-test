<template>
  <div class="main-layout">
    <navbar-full-width/>
    <sidebar-menu :menu="menu" :collapsed="menuCollapsed" @collapse="menuCollapse" />

    <div class="mt-4">
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
          href: {name: 'admin.permissions'},
          title: {translate: 'permissions'},
          icon: 'user-tie'
        },
        {
          href: {name: 'admin.menu'},
          title: {translate: 'menus'},
          icon: 'list-alt'
        },
        {
          href: {name: 'admin.taxonomy'},
          title: {translate: 'taxonomy'},
          icon: 'folder'
        },
        {
          href: {name: 'admin.content'},
          title: {translate: 'content'},
          icon: 'copy'
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