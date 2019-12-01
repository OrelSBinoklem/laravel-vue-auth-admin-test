<template lang="pug">


  .megamenu(ref="container")
      .row(v-if="mode === 'cards'")
        .item-wrap(v-for="item in menuDataFiltered").col-3
          component(v-bind:is="cardItem" :data="item" :mode="mode" @neded-materials="addItemStackLoadSpecial" @change-page="onChangePage")
      .row(v-if="mode === 'list'")
        .col-3.list-group-sidebar(:id="uniqIdForAffix")
          my-affix(
            class="list-scroll-fix"
            :scroll-container-selector="scrollContainerSelector"
            :relative-element-selector="'#' + uniqIdForAffix"
            :offset="{top: 0, bottom: 15}"
            :scroll-affix="true"
          )
            .list-group(:style="{width: listGroupWidth}")
              template(v-for="item in menuDataFiltered")
                button(type='button' @click="onChangeListCategory(item.slug)" :class="{active: curListCategory === item.slug}").list-group-item.list-group-item-action.d-flex.justify-content-between.align-items-center
                  | {{item.name}}
                  span(v-if="!!item.children && !!item.children.length" class="badge badge-primary badge-pill") {{item.children.length}}
        .col-9
          template(v-if="!!curList")
            component(v-bind:is="cardItem" :data="curList" :mode="mode" @neded-materials="addItemStackLoadSpecial" @change-page="onChangePage")

      .filter(v-if='!!filter')
        mega-filter(:data='filter' @change="onChangeFilter" @restored-filter="onChangeFilter")
          template(slot="t-r-special")
            .btns-mode.btn-group-vertical
              button(type='button' :class="{active: mode === 'cards'}" @click="onChangeMode('cards')").btn.btn-outline-primary: fa(icon='th')
              button(type='button' :class="{active: mode === 'list'}" @click="onChangeMode('list')").btn.btn-outline-primary: fa(icon='th-list')


</template>

<script>

const qs = require('qs');
import Vue from 'vue';
import $ from 'jquery';
import _ from 'lodash';
import axios from 'axios';

import {menuHelpers} from '../menu-items/menu-helpers';

import MegaFilter from "./MegaFilter";
import CardPlugin from "./CardsMenuItem/CardPlugin";
//todo вернуть нормальный affix когда его пофиксят https://github.com/eddiemf/vue-affix/issues/52
import MyAffix from "./MyAffix";

export default {
  name: 'MegaMenu',

  mixins: [menuHelpers],

  components: {
    MegaFilter,
    CardPlugin,
    MyAffix
  },

  props: {
    filter: {type: Object},
    items: {type: Array, required: true},
    cardItem: {type: String, required: true},
    scrollContainerSelector: {type: String, default: null},

    uniqIdForAffix: {type: String, required: true},
  },

  data() {
    return {
      menuData: [],
      stackLoadSpecial: [],
      filterNormalised: {
        slugs: {},
        groups: []
      },

      listGroupWidth: 'auto'
    }
  },

  computed: {
    /**
     * Режим отображения плагинов - карточками или списком
     *  @returns {String}
     */
    mode() {
      return this.$store.getters['interface/cardsOrListPlugins'];
    },

    curListCategory() {
      return this.$store.getters['interface/curListCategory'];
    },

    menuDataFiltered() {
      this.menuData.forEach((cat) => {
        if('originalChildren' in cat && !!cat.originalChildren.length) {
          cat.children = cat.originalChildren.filter((item) => {
            if(_.hasIn(item, 'categories'))
              return this.__matchesFilter(item.categories, this.filterNormalised);
            return true;
          });
        }
      });
      return this.menuData;
    },

    curList() {
      if(!!this.curListCategory) {
        let list = _.find(this.menuDataFiltered, {slug: this.curListCategory});
        return !!list ? list : null;
      }
      else
        return null;
    }
  },

  beforeMount() {
    this.__changeToFirstExistItemsListCat();
  },

  async mounted () {
    this.__setOriginalChildren(this.items);

    this.menuData = this.items;

    this.LoadSpecialThrottle = _.throttle(async () => {
      let clone = this.stackLoadSpecial.slice();
      this.stackLoadSpecial = [];
      await this.getFullMenuDataBySlug(clone);
    }, 1000);

    this.transferWidthSidebarAffixThrottle = _.throttle(() => {
      this.__transferWidthSidebarAffix();
    }, 500);

    window.addEventListener('resize', this.transferWidthSidebarAffixThrottle);

    this.transferWidthSidebarAffixThrottle();
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.transferWidthSidebarAffixThrottle);
  },

  methods: {
    onChangeMode(mode) {
      this.$store.dispatch('interface/saveCardsOrListPlugins', mode);
    },

    onChangeListCategory(slug) {
      this.$store.dispatch('interface/saveCurListCategory', slug);
    },

    onChangePage() {
      this.$emit('change-page');
    },

    addItemStackLoadSpecial(items) {
      if(Array.isArray(items)) {
        this.stackLoadSpecial = [...this.stackLoadSpecial, ...items];
      } else {
        this.stackLoadSpecial.push(items);
      }

      this.$nextTick(() => {
        this.LoadSpecialThrottle();
      });
    },

    async getFullMenuDataBySlug(items) {
      //Добавляем ссылку на parent в виде свойства parent
      this.__setParent(items)

      //Делаем данные плоскими
      let flat = this.__treeToFlat(items)

      //кеш
      flat.forEach((el) => {
        let data = this.$store.getters['menu/itemRelatedData'](el.id);
        if(data !== null) {
          el.material = data;
        }
      });

      //Получаем материалы которые связаны с пунктами "Материал"
      let result = await this.__getSpecialData(null, flat)

      if(!!result && 'data' in result) {
        let data = result['data'];

        //Нормализуем категории и тэги в материалах
        _.values(data).forEach((el) => {
          _.values(el).forEach((el) => {
            el.tags = _.keyBy(el.tags, 'slug')
            el.categories = _.keyBy(el.categories, 'slug')
          })
        });

        //К пунктам меню привязываем материалы
        flat.forEach((el) => {
          let type = el.meta_data.content_type;
          let slug = el.meta_data.material_slug;

          if(el.type_id === 2 && type in data && slug in data[type]) {
            Vue.set(el, 'material', data[type][slug]);
            this.$store.dispatch('menu/setItemsRelatedData', [{
              id: el.id,
              data: el.material
            }]);
          }
        });
      }

      return items;
    },

    async __getSpecialData(store, items) {
      let slugs = {}
      let temp = items.slice()
      _.remove(temp, function(item) {
        return item.type_id !== 2 || 'material' in item;
      });

      temp.forEach((item) => {
        if(!(item.meta_data.content_type in slugs)) {
          slugs[item.meta_data.content_type] = []
        }
        slugs[item.meta_data.content_type].push(item.meta_data.material_slug)
      });

      //удаляем повторные слаги
      _.mapValues(slugs, (val) => {
        return _.uniq(val);
      });

      if(temp.length) {
        return axios
          .get('/api/content/get-items-ppmm', {
            params: {'material-slugs': slugs},
            'paramsSerializer': function(params) {
              return qs.stringify(params)
            },
          })
      } else {
        return null;
      }
    },

    onChangeFilter(val) {
      this.setFilterNormalisedData(val);
    },

    /**
     * Нормализует данные для последующей быстрой проверки на соответствие фильтру элемента методом "__matchesFilter"
     * @param {Object} val
     */
    setFilterNormalisedData(val) {
      this.filterNormalised.slugs = {};
      this.filterNormalised.groups = [];

      _.forIn(val, (value, key) => {
        if(value !== null) {
          let checkedObj = {matched: false};
          this.filterNormalised.groups.push(checkedObj);

          if(typeof value == "string") {
            this.filterNormalised.slugs[value] = checkedObj;
          }
          else if(Array.isArray(value)) {
            value.forEach((value) => {
              this.filterNormalised.slugs[value] = checkedObj;
            });
          } else {
            throw new Error('value must be either a string or an array');
          }
        }
      });
    },

    /**
     * Проверяет соответствие элемента параметрам фильтра
     * @param {Array|Object} item
     * @param {Object} filterNormalised
     * @param {Object} filterNormalised.slugs - содержит все слаги категорий с которыми мы и сравниваем передаваемый элемент в "__matchesFilter"
     * в каждом свойстве-слаге содержиться спец. объект со свойством "matched" ссылка на 1 такой объект храниться во всех слагах из одной группы и
     * чтобы элемент соответствовал достаточно чтоб у него был хоть 1 слаг из такой группы
     * @param {[{}]} filterNormalised.groups - содержит спец. объекты всех групп и если во всех объектах свойство "matched" = true
     * то это означает что этот элемент соответствует вцелом фильтру
     * @private
     */
    __matchesFilter (item, filterNormalised) {
      this.filterNormalised.groups.forEach((el) => {el.matched = false});

      (Array.isArray(item) ? item : _.keysIn(item))
        .forEach((val) => {
          if(val in this.filterNormalised.slugs)
            this.filterNormalised.slugs[val].matched = true;
        });

      for(let el of this.filterNormalised.groups)
        if(!el.matched)
          return false;
      return true;
    },

    __setOriginalChildren(items) {
      items.forEach((item) => {
        if('children' in item && !!item.children.length && !('originalChildren' in item)){
          item.originalChildren = item.children.slice();
        }
      });
    },

    __changeToFirstExistItemsListCat() {
      if(this.mode === "list" && !this.curListCategory && _.hasIn(this, 'menuDataFiltered[0].slug')) {
        for(let i in this.menuDataFiltered) {
          if(!!this.menuDataFiltered[i].children && this.menuDataFiltered[i].children.length) {
            this.$store.dispatch('interface/saveCurListCategory', this.menuDataFiltered[i].slug);
            break;
          }
          if(i === this.menuDataFiltered.length - 1)
            this.$store.dispatch('interface/saveCurListCategory', this.menuDataFiltered[0].slug);
        }
      }
    },

    __transferWidthSidebarAffix() {
      this.listGroupWidth =  this.mode === "list" ? $('.list-group-sidebar', this.$refs.container).width() + 'px' : 'auto';
    }
  },

  watch: {
    async items(val, oldVal) {
      if(val !== oldVal) {
        this.__setOriginalChildren(val);
        this.menuData = val;
      }
    },

    menuDataFiltered() {
      this.__changeToFirstExistItemsListCat();
    },

    mode(mode) {
      if(this.mode === "cards")
        this.$store.dispatch('interface/saveCurListCategory', null);
      else
        this.__changeToFirstExistItemsListCat();

      this.$nextTick(function() {
        this.transferWidthSidebarAffixThrottle();
      });
    }
  }
}
</script>

<style lang="scss" scoped>
  .megamenu {

  }

  .item-wrap {
    margin-top: 15px;
    position: relative;
  }

  .item-wrap:hover {
    z-index: 3;
  }

  .list-group-sidebar {
    padding-top: 15px;
    padding-bottom: 15px;
  }

  .list-scroll-fix {

  }

  .filter {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 320px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
  }

  .btns-mode {
    margin-top: 6px;
  }
</style>

<style lang="scss">
  .megamenu {
    .__rail-is-vertical {
      right: auto;
      left: 2px;
    }
  }
</style>