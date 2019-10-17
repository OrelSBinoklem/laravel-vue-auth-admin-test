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

    <div class="nav-menu">

    </div>

    <b-button variant="outline-primary" class="btn-open-plugins-megamenu" @click="onOpenPluginsMegamenu"><fa icon="expand"></fa></b-button>
    <!--todo доделать сохранение состояния plugins-megamenu и зделать v-if а не v-show-->
    <div class="plugins-megamenu" v-if="openMegamenu">
      <vue-scroll :ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}">
        <div class="container">
          <MegaMenu v-if="!!menuData" :items="menuData" :filter="filterPlugins" :card-item="'CardPlugin'" @change-page="onChangePageMegamenu"></MegaMenu>
        </div>
      </vue-scroll>
      <b-button class="btn-close-megamenu" variant="outline-primary" size="lg" @click="onCloseMegamenu">
        <fa icon="times" size="lg"></fa>
      </b-button>
    </div>

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
  import {getRenderedMenuDataMixin} from '../components/menu-items/get-rendered-menu-data-mixin';

  //import NavbarFullWidth from "../components/NavbarFullWidth";
  import Navbar from '~/components/Navbar';
  import MegaMenu from '../components/plain-plugins/MegaMenu';
  import SidebarScrollHash from '../components/scroll-hash/SidebarScrollHash';

  export default {
    name: 'PlainPluginsLayout',

    mixins: [mGetSetScrollHash, getRenderedMenuDataMixin],

    components: {
      //NavbarFullWidth,
      Navbar,
      MegaMenu,
      SidebarScrollHash
    },

    data: () => ({
      filterPlugins: {
        gridMenu: {
          cols: [
            {title: 'Плагины', slug: 'plugins'},
            {title: 'Авторские', slug: 'authors-plugins'},
            {title: 'Заготовки', slug: 'blanks'},
          ],
          rows: [
            {icon: ['custom', 'jquery'], color: '#0865A7', slug: 'jquery'},
            {icon: ['fab', 'wordpress'], color: '#00769D', slug: 'wordpress'},
            {icon: ['fab', 'vuejs'], color: '#2EB47E', slug: 'vue'},
            {icon: ['fab', 'laravel'], color: '#F34D38', slug: 'laravel'},
          ],
          items: [
            //todo-mark может потом буду использовать функционал
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
          ]
        },

        categoriesMenuSlug: 'web-programming',

        options: [
          {rootCategory: 'sets', defText: '--Комплекты--'},
          {rootCategory: 'price', defText: '--Стоимость плагина--'},
          {rootCategory: 'rating', defText: '--Лучшее--'},
        ]
      },

      curMegaMenu: null,
      openMegamenu: false,

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

      onOpenPluginsMegamenu() {
        this.openMegamenu = true;
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
      },

      onCloseMegamenu() {
        this.openMegamenu = false;
      },

      onChangePageMegamenu() {
        this.openMegamenu = false;
      }
    },

    watch: {
      openMegamenu(val) {
        $('body').toggleClass('hidden-scroll', val);
      }
    },

    async beforeMount() {
      document.body.addEventListener('click', this.onClickOutsidePosition);

      if(this.$route.hash.substr(1) !== this.currentHash) {
        this.currentHashScrolled = this.currentHash = this.$route.hash.substr(1);
      }

      await this.getDataMenuBySlug('plain-plugins');
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

  .nav-menu {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 320px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .plugins-megamenu {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 100vw;
    background-color: #f7f9fb;
    z-index: 5;
  }

  .btn-open-plugins-megamenu {
    position: fixed;
    top: 10px;
    left: 320px;
  }

  .btn-close-megamenu {
    position: absolute;
    top: 0;
    right: 0;
    padding: 1rem 2rem;
    font-size: 2.5rem;
  }

  .btn-open-hash-menu {
    position: fixed;
    top: 10px;
    right: 320px;
  }

  .plain-plugins-hash-menu {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 320px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .plain-plugins-hash-menu.__expanded {
    width: 720px;
  }
</style>

<style lang="scss">
  /*todo перенести в глобальніе стили*/
  body.hidden-scroll {
    overflow: hidden;
  }
</style>
