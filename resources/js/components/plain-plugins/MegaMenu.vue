<template lang="pug">


  .megamenu
    .row
      .item-wrap(v-for="item in menuData").col-3
        component(v-bind:is="cardItem" :data="item" @neded-materials="addItemStackLoadSpecial" @change-page="onChangePage")


</template>

<script>

const qs = require('qs');
import Vue from 'vue';
import axios from 'axios';

import {menuHelpers} from '../menu-items/menu-helpers';

import CardPlugin from "./CardsMenuItem/CardPlugin";

export default {
  name: 'MegaMenu',

  mixins: [menuHelpers],

  components: {
    CardPlugin
  },

  props: {
    items: {type: Array, required: true},
    cardItem: {type: [String, null], required: true}
  },

  data() {
    return {
      menuData: [],
      curMenuData: [],
      stackLoadSpecial: []
    }
  },

  computed: {

  },

  async mounted () {
    this.menuData = this.items;

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
    }
  },
  watch: {
    async items(val) {
      this.menuData = this.items;
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
</style>

<style lang="scss">

</style>