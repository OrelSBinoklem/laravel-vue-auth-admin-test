<template>
  <div class="plain-plugins-layout">
    <!--<navbar-full-width/>-->
    <navbar :show-user="false">
      <b-button-group class="ml-auto">
        <b-form-select
                v-for="type in typesPriorityCopyTypeCode"
                @input="value => {priorityCopyTypeCodeChange(type.nameProp, value)}"
                :value='type.nameProp in priorityCopyTypeCode ? priorityCopyTypeCode[type.nameProp] : null'
                :options='type.variant'
                :key="type.nameProp"
        ></b-form-select>
      </b-button-group>
      <!--todo-hot зделать выпадашку с турами и пункт сбросить все туры показать оповещение чтоб перезагрузил браузер-->
      <b-dropdown class="ml-2" variant="outline-secondary">
        <template slot="button-content">
          <fa icon="eye"></fa> Туры
        </template>
        <b-dropdown-item @click.prevent="onShowTour('select-plugins-cat')">Левое меню с модулями</b-dropdown-item>
        <b-dropdown-item @click.prevent="onResetTours"><fa icon="broom"></fa> Показывать все подсказки заново</b-dropdown-item>
      </b-dropdown>
    </navbar>

    <div class="section-nav-menu">
      <SectionSidebarSelectPlugin
        :menu-nav="menuNav"
        :cur-filter="curFilter"
        :cur-filter-cats="curFilterCats"
        @select-filter="onSelectFilter"
      ></SectionSidebarSelectPlugin>
    </div>

    <b-button variant="outline-primary" class="btn-open-plugins-megamenu" @click="onOpenPluginsMegamenu"><fa icon="expand"></fa></b-button>
    <div class="plugins-megamenu" v-if="openMegamenu">
      <vue-scroll :ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}">
        <div class="container">
          <MegaMenu
            v-if="!!menuData"
            :items="menuData"
            :filter="filterPlugins"
            :card-item="'CardPlugin'"
            @change-page="onChangePageMegamenu"

            scroll-container-selector=".plugins-megamenu .__vuescroll .__panel"
            uniq-id-for-affix="list-plugins"
          ></MegaMenu>
        </div>
      </vue-scroll>
      <b-button class="btn-close-megamenu" variant="outline-primary" size="lg" @click="onCloseMegamenu">
        <fa icon="times" size="lg"></fa>
      </b-button>
    </div>

    <div class="plain-plugins-hash-menu">
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

    <v-tour-overlay name="myTour" :steps="steps"></v-tour-overlay>
    <notifications></notifications>
  </div>
</template>

<script>
  import Vue from 'vue';
  import $ from 'jquery';

  import { mapGetters } from 'vuex';

  import {mGetSetScrollHash} from '../components/scroll-hash/mGetSetScrollHash';
  import {getRenderedMenuDataMixin} from '../components/menu-items/get-rendered-menu-data-mixin';
  import {menuHelpers} from '../components/menu-items/menu-helpers';

  //import NavbarFullWidth from "../components/NavbarFullWidth";
  import Navbar from '~/components/Navbar';
  import MegaMenu from '../components/plain-plugins/MegaMenu';
  import SectionSidebarSelectPlugin from '../components/SectionSidebarSelectPlugin';
  import SidebarScrollHash from '../components/scroll-hash/SidebarScrollHash';
  import VTourOverlay from '../components/VTourOverlay';

  export default {
    name: 'PlainPluginsLayout',

    mixins: [mGetSetScrollHash, menuHelpers, getRenderedMenuDataMixin],

    components: {
      //NavbarFullWidth,
      Navbar,
      MegaMenu,
      SectionSidebarSelectPlugin,
      SidebarScrollHash,
      VTourOverlay
    },

    data: () => ({
      filterPlugins: {
        gridMenu: {
          cols: [
            {title: 'JQuery и ванилла', icon: ['custom', 'jquery'], color: '#0865A7', slug: 'jquery'},
            {title: 'WordPress', icon: ['fab', 'wordpress'], color: '#00769D', slug: 'wordpress'},
            {title: 'Vue', icon: ['fab', 'vuejs'], color: '#2EB47E', slug: 'vue'},
            {title: 'Laravel', icon: ['fab', 'laravel'], color: '#F34D38', slug: 'laravel'},
          ],
          rows: [
            {title: 'Плагины', icon: 'users', color: '#333333', slug: 'plugins'},
            {title: 'Авторские', icon: 'user-friends', color: '#333333', slug: 'authors-plugins'},
            {title: 'Заготовки', icon: 'file-code', color: '#333333', slug: 'blanks'},
          ],
          items: [
            //todo-mark может потом буду использовать функционал
            ['', '', '', ''],
            ['', '', '', ''],
            ['', '', '', ''],
          ]
        },

        //categoriesMenuSlug: 'web-programming',

        options: [
          {rootCategory: 'sets', defText: '--Комплекты--'},
          {rootCategory: 'price', defText: '--Стоимость плагина--'},
          {rootCategory: 'rating', defText: '--Лучшее--'},
        ]
      },

      menuNav: null,
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
        columnsSlide: 1,
        modeNoSlider: true
      },

      steps: [
        {
          target: '.bs-sidebar-menu-nested-drop',
          content: `Меню плагинов и пакетов<br>1-й уровень вложенности разделы,<br>2-й плагины и пакеты,<br>3-й разные дополнения`,
          params: {
            placement: 'right'
          }
        },
        {
          target: '.nav-menu-filter',
          content: 'Фильтр по технологиям'
        }
      ],
    }),

    computed: {
      menuState() {
        return this.$store.getters['interface/contentPluginsSidebarMegamenu']
      },

      priorityCopyTypeCode() {
        return this.$store.getters['interface/priorityCopyTypeCode']
      },

      ...mapGetters({
        curFilter: 'interface/filterMenuNavPlugins',
        curFilterCats: 'interface/filterCatsMenuNavPlugins',
        hashGroups: 'interface/hashGroups',
        navHashes: 'interface/navHashes',
        showTour: 'interface/showTour'
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

      onCloseMegamenu() {
        this.openMegamenu = false;
      },

      onChangePageMegamenu() {
        this.openMegamenu = false;
      },

      onSelectFilter(slug, cats) {
        this.$store.dispatch('interface/saveFilterMenuNavPlugins', slug);
        this.$store.dispatch('interface/saveFilterCatsMenuNavPlugins', cats);
      },

      async getAllCategories(items) {
        //Добавляем ссылку на parent в виде свойства parent
        this.__setParent(items);

        //Делаем данные плоскими
        let flat = this.__treeToFlat(items);

        //++++++++++++++++++++++
        let slugs = {};
        let temp = flat.slice();
        _.remove(temp, function(item) {
          return item.type_id !== 2 || 'material' in item;
        });

        temp.forEach((item) => {
          if(!(item.meta_data.content_type in slugs)) {
            slugs[item.meta_data.content_type] = true;
          }
        });

        let result;
        if(temp.length) {
          await this.$store.dispatch('db/loadTaxPublicPPMM', slugs);
          let data = this.$store.getters['db/taxPublicPPMM'];
          result = {data};
        } else {
          result = null;
        }

        //++++++++++++++++++
        if(!!result && 'data' in result) {
          let data = result['data'];

          //Нормализуем категории и тэги в материалах
          _.values(data).forEach((el) => {
            _.values(el).forEach((el) => {
              if(Array.isArray(el.tags))
                el.tags = _.keyBy(el.tags, 'slug')
              if(Array.isArray(el.categories))
                el.categories = _.keyBy(el.categories, 'slug')
            })
          });

          //К пунктам меню привязываем категории и тэги
          flat.forEach((el) => {
            let type = el.meta_data.content_type;
            let slug = el.meta_data.material_slug;

            if(el.type_id === 2 && type in data && slug in data[type]) {
              Vue.set(el, 'categories', data[type][slug].categories);
              Vue.set(el, 'tags', data[type][slug].tags);
            }
          });
        }

        return items;
      },

      onShowTour (slug) {
        switch (slug) {
          case 'select-plugins-cat':
            this.$tours['myTour'].start()
            break
        }
      },

      onResetTours () {
        this.$store.dispatch('interface/saveShowTour', {slug: 'select-plugins-cat', show: true});
        this.$eventHub.$emit('open-modal', {
          type: 'info',
          title: null,
          message: "Перезагрузите страницу!"
        });
      }
    },

    watch: {
      openMegamenu(val) {
        $('body').toggleClass('hidden-scroll', val);
      }
    },

    async beforeMount() {
      if(this.$route.hash.substr(1) !== this.currentHash) {
        this.currentHashScrolled = this.currentHash = this.$route.hash.substr(1);
      }

      await this.getDataMenuBySlug('plain-plugins');

      this.menuData = await this.getAllCategories(this.menuData);

      //дублируем объект данных для обычного меню
      this.menuNav = this.menuData.map((item) => {
        let result = {...item};
        if('children' in result && !!result.children.length && !('originalChildren' in result)){
          result.originalChildren = result.children.slice();
        }
        return result;
      });
    },

    mounted: function () {
      if(this.showTour('select-plugins-cat') !== false)
        setTimeout(() => {
            this.$tours['myTour'].start()
            this.$store.dispatch('interface/saveShowTour', {slug: 'select-plugins-cat', show: false});
        }, 2000)
    },

    beforeDestroy() {

    }
  }
</script>

<style lang="scss" scoped>
  .plain-plugins-layout {
    > .menu {
      z-index: 1035;
    }
  }

  .section-nav-menu {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 320px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    z-index: 5;
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

</style>

<style lang="scss">
  /*todo перенести в глобальные стили*/
  body.hidden-scroll {
    overflow: hidden;
  }
</style>
