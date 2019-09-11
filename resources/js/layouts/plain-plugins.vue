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
            @state-change="menuStateChange"
    />

    <b-button variant="outline-primary" class="btn-open-hash-menu" @click="onOpenHashMenu"><fa icon="expand"></fa></b-button>
    <div class="plain-plugins-hash-menu" :class="{__expanded: optHashMenu.modeNoSlider}">
      <sidebar-scroll-hash
        :current-hash="currentHash"
        :current-hash-scrolled="currentHashScrolled"
        @update:current-hash="updateCurrentHash"
        :groups="hashGroups"
        :hashes="navHashes"
        :mode-priority-group="{sizeFactor: 2, percentageOfMenuItemsRelativeToArithmeticMean: 150}"
        :mode-no-slider="optHashMenu.modeNoSlider"
        :columns-slide="optHashMenu.columnsSlide"
      />
    </div>

    <div class="container mt-4">
      <child/>
    </div>
    <notifications></notifications>
  </div>
</template>

<script>
  import $ from 'jquery';

  import { mapGetters } from 'vuex';

  import {mGetSetScrollHash} from '../components/scroll-hash/mGetSetScrollHash';

  //import NavbarFullWidth from "../components/NavbarFullWidth";
  import Navbar from '~/components/Navbar';
  import SidebarMegamenu from '../components/sidebar-megamenu/SidebarMegamenu';
  import SidebarScrollHash from '../components/scroll-hash/SidebarScrollHash';

  export default {
    name: 'PlainPluginsLayout',

    mixins: [mGetSetScrollHash],

    components: {
      //NavbarFullWidth,
      Navbar,
      SidebarMegamenu,
      SidebarScrollHash
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
      ],

      currentHashScrolled: '',
      currentHash: '',
      optHashMenu: {
        columnsSlide: 2,
        modeNoSlider: false
      }
    }),

    computed: {
      menuState() {
        return this.$store.getters['interface/contentPluginsSidebarMegamenu']
      },

      priorityCopyTypeCode() {
        return this.$store.getters['interface/priorityCopyTypeCode']
      },

      ...mapGetters({
        hashGroups: 'interface/hashGroups',
        navHashes: 'interface/navHashes'
      }),
    },

    methods: {
      menuStateChange(state) {
        this.$store.dispatch('interface/saveContentPluginsSidebarMegamenu', state)
      },

      priorityCopyTypeCodeChange(nameProp, state) {
        this.priorityCopyTypeCode[nameProp] = state
        this.$store.dispatch('interface/savePriorityCopyTypeCode', this.priorityCopyTypeCode)
      },

      onOpenHashMenu() {
        this.optHashMenu.columnsSlide = 4;
        this.optHashMenu.modeNoSlider = true;
      },

      onClickOutsidePosition(e) {
        if (!($(e.target).closest('.plain-plugins-hash-menu, .btn-open-hash-menu').length)) {
          this.optHashMenu.columnsSlide = 2;
          this.optHashMenu.modeNoSlider = false;
        }
      }
    },

    watch: {

    },

    beforeMount() {
      document.body.addEventListener('click', this.onClickOutsidePosition);

      if(this.$route.hash.substr(1) !== this.currentHash) {
        this.currentHashScrolled = this.currentHash = this.$route.hash.substr(1);
      }
    },

    beforeDestroy() {
      document.body.removeEventListener('click', this.onClickOutsidePosition);
    }
  }
</script>

<style lang="scss" scoped>
  .plain-plugins-layout {
    > .menu {
      z-index: 1035;
    }
  }


  .btn-open-hash-menu {
    position: fixed;
    top: 10px;
    right: 360px;
  }


  .plain-plugins-hash-menu {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 360px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .plain-plugins-hash-menu.__expanded {
    width: 720px;
  }
</style>
