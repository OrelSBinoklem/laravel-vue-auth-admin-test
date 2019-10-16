<template lang="pug">


  .tree-checked(ref="container")
    //todo-bug плагин тупой при выборе чекбокса он генерирует несколько событий если есть дочерние элементы и в них автоматом выбираються чекбоксы
    tree(
      v-if="!!categories"
      :data="categories"
      :options="treeOptions"
      @node:checked="onChecked"
      @node:unchecked="onChecked"
      ref="tree"
    )


</template>

<script>

import Vue from 'vue';
import $ from 'jquery';
import _ from 'lodash';

export default {
  name: 'CategoriesTree',

  components: {

  },

  props: {
    rootCategory: {type: String, default: null},
  },

  data() {
    return {
      selectData: [],
      triggerData: false,

      treeOptions: {
        checkbox: true,
        propertyNames: {
          text: 'title'
        }
      }
    }
  },

  async beforeMount () {
    await this.$store.dispatch('db/loadCategoriesPublic');
  },

  mounted () {

  },

  computed: {
    categoriesAllFlat() {
      if(!!this.rootCategory) {
        return this.$store.getters['db/categoriesPublic'];
      } else {
        return null;
      }
    },

    categories() {
      if(!!this.rootCategory) {
        return this.$store.getters['db/categoriesPublicTree'](this.rootCategory);
      } else {
        return null;
      }
    }
  },

  methods: {
    onChecked() {
      this.selectData = this.$refs.tree.checked();
      if(!this.triggerData) {
        this.triggerData = true;
        //todo-hack если выбрать элемент и если у него есть дочерние элементы то вызываеться несколько событьй код ниже решает данную проблему
        Vue.nextTick( () => {
          this.triggerData = false;

          if(!!this.categoriesAllFlat) {
            let all = [];
            let checked = this.$refs.tree.findAll({state: {checked: true}});
            //todo-mark indeterminate нужно для алгоритма фильтра чтобы выбирать и тот код или плагины которые более широкие но включают в себя категории из дочерних относительно той что indeterminate
            let indeterminate = this.$refs.tree.findAll({state: {indeterminate: true}});

            if(checked !== null)
              all = [...all, ...checked];
            if(indeterminate !== null)
              all = [...all, ...indeterminate];

            if(!!all.length) {
              let ids = _.keyBy(all, 'id');
              let categories = this.categoriesAllFlat.filter((el) => {
                return el.id in ids;
              });

              this.$emit('checked-and-intermediate', categories);
            } else {
              this.$emit('checked-and-intermediate', null);
            }
          } else {
            this.$emit('checked-and-intermediate', null);
          }
        })
      }
    }
  },

  watch: {

  }
}
</script>

<style lang="scss" scoped>

</style>

<style lang="scss">

</style>