<template lang="pug">


  .megamenu
      .row
        .item-wrap(v-for="item in menuDataFiltered").col-3
          component(v-bind:is="cardItem" :data="item" @neded-materials="addItemStackLoadSpecial" @change-page="onChangePage")

      .filter(v-if='!!filter')
        vue-scroll(:ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}")
          mega-filter(:data='filter' @change="onChangeFilter")


</template>

<script>

const qs = require('qs');
import Vue from 'vue';
import axios from 'axios';

import {menuHelpers} from '../menu-items/menu-helpers';

import MegaFilter from "./MegaFilter";
import CardPlugin from "./CardsMenuItem/CardPlugin";

export default {
  name: 'MegaMenu',

  mixins: [menuHelpers],

  components: {
    MegaFilter,
    CardPlugin
  },

  props: {
    filter: {type: Object},
    items: {type: Array, required: true},
    cardItem: {type: [String, null], required: true}
  },

  data() {
    return {
      menuData: [],
      curMenuData: [],
      stackLoadSpecial: [],
      filterNormalised: {
        slugs: {},
        groups: []
      }
    }
  },

  computed: {
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
    }
  },

  async mounted () {
    this.__setOriginalChildren(this.items)
    this.menuData = await this.getAllCategories(this.items);

    this.LoadSpecialThrottle = _.throttle(async () => {
      let clone = this.stackLoadSpecial.slice();
      this.stackLoadSpecial = [];
      await this.getFullMenuDataBySlug(clone);
    }, 1000);
  },

  methods: {
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
        result = await axios
          .get('/api/content/get-all-tax-ppmm', {
            params: {'material-slugs': slugs},
            'paramsSerializer': function(params) {
              return qs.stringify(params)
            },
          })
      } else {
        result = null;
      }

      //++++++++++++++++++
      if(!!result && 'data' in result) {
        let data = result['data'];

        //Нормализуем категории и тэги в материалах
        _.values(data).forEach((el) => {
          _.values(el).forEach((el) => {
            el.tags = _.keyBy(el.tags, 'slug')
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
     * то это означает что этомент соответствует вцелом фильтру
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
        if('children' in item && !!item.children.length){
          item.originalChildren = item.children.slice();
        }
      });
    }
  },

  watch: {
    async items(val, oldVal) {
      if(val !== oldVal) {
        this.__setOriginalChildren(val);
        this.menuData = val;
      }
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

  .filter {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 320px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
  }
</style>

<style lang="scss">
  .megamenu {
    .__rail-is-vertical {
      right: auto;
      left: 2px;
    }

    .mega-filter {
      padding-left: 10px;
      padding-right: 10px;
    }
  }
</style>