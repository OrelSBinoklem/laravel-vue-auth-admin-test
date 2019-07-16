<template>
  <div class="plain-plugins-layout">
    <!--<navbar-full-width/>-->
    <navbar>

      <b-button-group class="ml-auto">
        <b-form-select
                v-for="type in typesPriorityCopyTypeCode"
                @input="value => {priorityCopyTypeCodeChange(type.nameProp, value)}"
                :value='type.nameProp in priorityCopyTypeCode ? priorityCopyTypeCode[type.nameProp] : null'
                :options='type.variant'
                :key="type.nameProp"
        >
        </b-form-select>
      </b-button-group>
    </navbar>

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
      ],

      typesPriorityCopyTypeCode: [
        {
          nameProp: 'layouts',
          variant: [
            { value: null, text: 'Разметка' },
            { value: 'html', text: 'HTML' },
            { value: 'jade', text: 'PUG' },
          ]
        },
        {
          nameProp: 'styles',
          variant: [
            { value: null, text: 'Стили' },
            { value: 'css', text: 'CSS' },
            { value: 'sass', text: 'SASS' },
            { value: 'scss', text: 'SCSS' },
            //{ value: 'less', text: 'LESS' },
            //{ value: 'stylus', text: 'Stylus' },
          ]
        },
        {
          nameProp: 'js',
          variant: [
            { value: null, text: 'Тип JS' },
            { value: 'javascript', text: 'JS' },
            { value: 'typescript', text: 'TScript' },
            //{ value: 'coffee', text: 'Coffee' },
          ]
        }
      ]
    }),

    computed: {
      menuState() {
        return this.$store.getters['interface/contentPluginsSidebarMegamenu']
      },

      priorityCopyTypeCode() {
        return this.$store.getters['interface/priorityCopyTypeCode']
      }
    },

    methods: {
      menuStateChange(state) {
        this.$store.dispatch('interface/saveContentPluginsSidebarMegamenu', state)
      },

      priorityCopyTypeCodeChange(nameProp, state) {
        this.priorityCopyTypeCode[nameProp] = state
        this.$store.dispatch('interface/savePriorityCopyTypeCode', this.priorityCopyTypeCode)
      }
    }
  }
</script>

<style lang="sass" scoped>
.plain-plugins-layout
  > .menu
    z-index: 1035
</style>
