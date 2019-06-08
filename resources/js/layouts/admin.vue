<template>
  <div class="main-layout">
    <navbar/>
    <sidebar-menu :menu="menu" :collapsed="menuCollapsed" @collapse="menuCollapse" />

    <SidebarMenuWidgets
      v-show="this.$route.name === 'admin.content.create' || this.$route.name === 'admin.content.update'">
    </SidebarMenuWidgets>

    <div class="main-layout__content">
      <child/>
    </div>
    <notifications></notifications>
  </div>
</template>

<script>
  //import NavbarFullWidth from "../components/NavbarFullWidth";
  import Navbar from '../components/Navbar'
  import SidebarMenu from '../components/sidebar-menu/SidebarMenu';
  import SidebarMenuWidgets from "../components/menu-widgets/SidebarMenuWidgets";

  export default {
    name: 'AdminLayout',

    components: {
      //NavbarFullWidth,
      Navbar,
      SidebarMenu,
      SidebarMenuWidgets
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