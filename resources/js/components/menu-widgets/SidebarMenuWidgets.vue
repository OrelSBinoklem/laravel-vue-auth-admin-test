<template lang="pug">
  .menu.sidebar-menu-widgets
    b-button.btn-open-megamenu(variant='outline-primary', @click='onOpenMegamenu'): fa(icon='expand')
    .wrap-scroll-list-menu
      vue-scroll(:ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}")
        .wrap-list-menu
          component(v-for="type in types" :is="slugToNameComponent(type.slug)" v-bind="{megamenu: openMegamenu}" :key="type.slug")
    .megamenu-wrap(v-if='openMegamenu')
      //vue-scroll(:ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}")
      .megamenu-container.container-fluid
        .row
          .col-2.col-nav
            vue-scroll(:ops="{bar: {background: '#D6E9F8'}, scrollPanel: {scrollingX: false}}")
              b-list-group(v-b-scrollspy:megamenu-widget-types='')
                b-list-group-item(v-for="type in types" :href="'#megamenu-widget-type-' + type.slug" :key="type.slug") {{type.name}}
          .col-10.col-scroll
            #megamenu-widget-types(v-for="type in types")
              .name-type(:id="'megamenu-widget-type-' + type.slug") {{type.name}}
              component(:is="slugToNameComponent(type.slug)" v-bind="{megamenu: openMegamenu}" :key="type.slug")
      b-button.btn-close-megamenu(variant='outline-primary', size='lg', @click='onCloseMegamenu'): fa(icon='times', size='lg')

</template>

<script>
  import _ from 'lodash'
  import {types} from "../content-widgets/types";
  import MenuAlert from "../content-widgets/alert/Menu";

  export default {
    name: "MenuWidgets",

    components: {
      MenuAlert
    },

    props: {

    },

    beforeMount() {

    },

    data: () => ({
      types,

      openMegamenu: false
    }),

    computed: {

    },

    methods: {
      onOpenMegamenu() {
        this.openMegamenu = true
      },

      onCloseMegamenu() {
        this.openMegamenu = false
      },

      slugToNameComponent(slug) {
        return 'Menu' + _.camelCase(slug).charAt(0).toUpperCase() + _.camelCase(slug).slice(1)
      }
    },

    watch: {

    }
  }
</script>

<style lang="sass" scoped>
  .menu
    position: fixed
    top: 0
    right: 0
    bottom: 0
    width: 280px
    background-color: #fff
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5)
    z-index: 1035

  .wrap-list-menu
    padding: 15px

  .btn-open-megamenu
    position: absolute
    //top: calc(50vh - 18px)
    top: 10px
    right: calc(100% + 10px)
    width: 37px
    height: 37px
    display: flex
    justify-content: center
    align-items: center
    border-radius: 50%

  .megamenu-wrap
    position: fixed
    top: 0
    left: 0
    bottom: 0
    width: 100vw
    background-color: #fff

  .col-nav
    max-height: calc(100vh - 60px)

  .col-scroll
    max-height: calc(100vh - 60px)
    overflow-y: auto

  .megamenu-container
    padding-top: 30px
    padding-bottom: 30px

  .btn-close-megamenu
    position: absolute
    top: 0
    right: 0
    padding: 1rem 2rem
    font-size: 2.5rem
</style>