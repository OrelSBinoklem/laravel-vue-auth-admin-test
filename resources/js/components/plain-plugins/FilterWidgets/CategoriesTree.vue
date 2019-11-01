<template lang="pug">


  .tree-checked(ref="container")
    //todo-bug плагин тупой при выборе чекбокса он генерирует несколько событий если есть дочерние элементы и в них автоматом выбираються чекбоксы
    tree(
      v-if="!!categories"
      :data="categories"
      :options="treeOptions"
      @node:checked="onChecked"
      @node:unchecked="onChecked"
      @node:expanded="onToggleCollapse"
      @node:collapsed="onToggleCollapse"
      ref="tree"
      class="tree--small"
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
    select: {type: Array},
    expanded: {type: Array},
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
    /**
     * Парсит выбранные чекбоксы и частично выбранные и генерирует событие "checked"
     */
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
            let indeterminate = this.$refs.tree.findAll({state: {indeterminate: true}});

            if(checked !== null && !!checked.length) {
              let ids = _.keyBy(checked, 'id');
              let categories = this.categoriesAllFlat.filter((el) => {
                return el.id in ids;
              });

              if(indeterminate !== null && !!indeterminate.length) {
                let ids = _.keyBy(indeterminate, 'id');
                let categoriesIndeterminate = this.categoriesAllFlat.filter((el) => {
                  return el.id in ids;
                });

                this.$emit('checked', categories, categoriesIndeterminate);
              } else {
                this.$emit('checked', categories, null);
              }
            } else {
              this.$emit('checked', null, null);
            }

          } else {
            this.$emit('checked', null, null);
          }
        })
      }
    },

    onToggleCollapse() {
      let expanded = this.$refs.tree.findAll({state: {expanded: true}});

      if(expanded !== null)
        this.$emit('toggle-collapse', expanded.map((el) => {return el.id}));
      else
        this.$emit('toggle-collapse', null);
    },

    /**
     * Берёт "select" пропс и применяет
     * @private
     */
    __applySelectProp() {
      let checked = this.$refs.tree.findAll({state: {checked: true}});

      //Когда приходит массив
      if(!!this.select && !!this.select.length) {
        //Когда приходит массив и чтото уже выбрано
        if(checked !== null) {
          let ids = _.keyBy(checked, 'id');
          let select = this.categoriesAllFlat.filter((el) => {return el.id in ids}).map(cat => cat.slug);

          //Если пришол массив и чтото выбрано то синхронизируем
          let isDiff = false;
          if(this.select.length !== select.length)
            isDiff = true;
          else
            for(let i in this.select)
              if(this.select[i] !== select[i]) {
                isDiff = true;
                break;
              }

          if(isDiff) {

            checked.uncheck();

            let all = this.$refs.tree.findAll({state: {checked: false}});
            let slugsNew = this.select.reduce((acc, slug) => {acc[slug] = true; return acc}, {});
            let idsNew = this.categoriesAllFlat
              .filter((el) => {return el.slug in slugsNew})
              .map(cat => cat.id)
              .reduce((acc, id) => {acc[id] = true; return acc}, {});

            for(let i in all)
              if(all[i].id in idsNew)
                all[i].check();
          }

          //Когда приходит массив и ничего выбрано
        } else {
          let all = this.$refs.tree.findAll({state: {checked: false}});
          let slugsNew = this.select.reduce((acc, slug) => {acc[slug] = true; return acc}, {});
          let idsNew = this.categoriesAllFlat
            .filter((el) => {return el.slug in slugsNew})
            .map(cat => cat.id)
            .reduce((acc, id) => {acc[id] = true; return acc}, {});

          for(let i in all)
            if(all[i].id in idsNew)
              all[i].check();
        }
      }

      //Когда приходит null
      if(this.select === null && checked !== null)
        checked.uncheck();
    },

    __applyExpandedProp() {
      let expanded = this.$refs.tree.findAll({state: {expanded: true}});

      //Когда приходит массив
      if(!!this.expanded && !!this.expanded.length) {
        //Когда приходит массив и чтото уже выбрано
        if(expanded !== null) {
          let idsExpanded = expanded.map(cat => cat.id);

          //Если пришол массив и чтото выбрано то синхронизируем
          let isDiff = false;
          if(this.expanded.length !== idsExpanded.length)
            isDiff = true;
          else
            for(let i in this.expanded)
              if(this.expanded[i] !== idsExpanded[i]) {
                isDiff = true;
                break;
              }

          if(isDiff) {

            expanded.collapse();

            let all = this.$refs.tree.findAll({state: {expanded: false}});
            let idsNew = this.expanded.reduce((acc, id) => {acc[id] = true; return acc}, {});

            for(let i in all)
              if(all[i].id in idsNew)
                all[i].expand();
          }

          //Когда приходит массив и ничего выбрано
        } else {
          let all = this.$refs.tree.findAll({state: {expanded: false}});
          let idsNew = this.expanded.reduce((acc, id) => {acc[id] = true; return acc}, {});

          for(let i in all)
            if(all[i].id in idsNew)
              all[i].expand();
        }
      }

      //Когда приходит null
      if(this.expanded === null && expanded !== null)
        expanded.collapse();
    },
  },

  watch: {
    select: function () {
      if(!!this.$refs.tree)
        this.__applySelectProp();
    },

    expanded: function () {
      if(!!this.$refs.tree)
        this.__applyExpandedProp();
    },

    categories: function () {
      Vue.nextTick( () => {
        Vue.nextTick( () => {
          if(!!this.$refs.tree)
            this.__applySelectProp();
            this.__applyExpandedProp();
        });
      });
    }
  }
}
</script>

<style lang="scss" scoped>

</style>

<style lang="scss">
  .tree-checked {
    .tree-content {
      padding-top: 1px;
      padding-bottom: 1px;
    }
  }
</style>