<template>
  <div class="main-layout">
    <!--<navbar-full-width/>-->
    <navbar/>

    <sidebar-megamenu
            :menus="menus"
            :menustart="'currentTab' in menuState ? menuState.currentTab : 'plain-plugins'"
            :state="menuState"
            @state-change="menuStateChange" />

    <div class="container mt-4">
      <child/>
    </div>
    <notifications></notifications>
  </div>
</template>

<script>
  //import NavbarFullWidth from "../components/NavbarFullWidth";
  import Navbar from '~/components/Navbar'
  import SidebarMegamenu from '../components/sidebar-megamenu/SidebarMegamenu';

  export default {
    name: 'PlainPluginsLayout',

    components: {
      //NavbarFullWidth,
      Navbar,
      SidebarMegamenu
    },

    data: () => ({
      menus: [
        {icon: ['custom', 'jquery'], menuSlug: 'plain-plugins', color: '#0865A7'},
        {icon: ['fab', 'wordpress'], menuSlug: 'plain-plugins2', color: '#00769D'},
        {icon: ['fab', 'vuejs'], menuSlug: 'plain-plugins3', color: '#2EB47E'},
        {icon: ['fab', 'laravel'], menuSlug: 'plain-plugins4', color: '#F34D38'}
      ]
    }),

    computed: {
      menuState() {
        return this.$store.getters['interface/contentPluginsSidebarMegamenu']
      }
    },

    methods: {
      menuStateChange(state) {
        this.$store.dispatch('interface/saveContentPluginsSidebarMegamenu', state)
      }
    }
  }
</script>

<style lang="sass" scoped>

</style>
