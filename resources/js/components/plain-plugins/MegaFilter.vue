<template lang="pug">


  .mega-filter

    .filter-grid-and-mode
      .grid-menu(v-if="!!data.gridMenu")
        grid-menu(:data="data.gridMenu" :select-col="selected.framework" :select-row="selected.code_type" @select="onSelectGridMenu" mode="compact")
      .filter-mode
        button.btn-clear(type="button" @click="onClear" :disabled="!isFilterSelected" :class="{active: isFilterSelected}").btn.btn-sm.btn-outline-dark: fa(icon='broom')
        slot(name="t-r-special")

    .filter-categories(v-if="!!data.categoriesMenuSlug")
      vue-scroll(:ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}")
        categories-tree(:root-category="data.categoriesMenuSlug" :select="selected.categories" @checked="onChangeCat" :expanded="saveSpecialState.categoriesExpanded" @toggle-collapse="onToggleCollapseCat")

    .filter-options(v-if="!!data.options")
      .filter-options-shadow-wrap: .filter-options-shadow
      .filter-options-content
        category-select(v-for="opt in data.options" :select="selected[opt.rootCategory]" @select="(val) => {onSelectOption(opt.rootCategory, val)}" :root-category="opt.rootCategory" :default-text="opt.defText" :key="opt.rootCategory")


</template>

<script>
import Vue from 'vue'

import GridMenu from './FilterWidgets/GridMenu';
import CategoriesTree from './FilterWidgets/CategoriesTree';
import CategorySelect from './FilterWidgets/CategorySelect';

export default {
  name: 'MegaFilter',

  components: {
    GridMenu,
    CategoriesTree,
    CategorySelect,
  },

  props: {
    data: {type: Object, required: true}
  },

  data() {
    return {
      special: {
        categoriesIntermediate: null
      },

      saveSpecialState: {
        categoriesExpanded: null
      },

      selected: {
        framework: null,
        code_type: null,

        categories: null
      },

      filter: {
        framework: null,
        code_type: null,

        categories: null
      }
    }
  },

  beforeMount() {
    this.data.options.forEach((opt) => {
      Vue.set(this.selected, opt.rootCategory, null);
      Vue.set(this.filter, opt.rootCategory, null);
    });

    Vue.nextTick( () => {
      if('special' in this.filterStore)
        Vue.set(this, 'special',          this.filterStore.special);
      if('saveSpecialState' in this.filterStore)
        Vue.set(this, 'saveSpecialState', this.filterStore.saveSpecialState);
      if('selected' in this.filterStore)
        Vue.set(this, 'selected',         this.filterStore.selected);
      if('filter' in this.filterStore)
        Vue.set(this, 'filter',           this.filterStore.filter);

      this.$emit('restored-filter', this.filter);
    });
  },

  mounted () {

  },

  methods: {
    onSelectGridMenu(val) {
      this.selected.code_type = this.filter.code_type = val.row === 'all' || val.row === null ? null : this.data.gridMenu.rows[val.row].slug;
      this.selected.framework = this.filter.framework = val.col === 'all' || val.col === null ? null : this.data.gridMenu.cols[val.col].slug;

      this.__saveStateFilters();
      this.$emit('change', this.filter);
    },

    onChangeCat(categories, categoriesIntermediate) {
      this.selected.categories = !!categories ? categories.map(cat => cat.slug) : null;
      this.special.categoriesIntermediate = !!categoriesIntermediate ? categoriesIntermediate.map(cat => cat.slug) : null;

      //todo-mark indeterminate нужно для алгоритма фильтра чтобы выбирать и тот код или плагины которые более широкие но включают в себя категории из дочерних относительно той что indeterminate
      let all = [];
      if(this.selected.categories !== null)
        all = [...all, ...this.selected.categories];
      if(this.special.categoriesIntermediate !== null)
        all = [...all, ...this.special.categoriesIntermediate];

      this.filter.categories = !!all.length ? all : null;

      this.__saveStateFilters();
      this.$emit('change', this.filter);
    },

    onToggleCollapseCat(expanded) {
      this.saveSpecialState.categoriesExpanded = expanded;
      this.__saveStateFilters();
    },

    onSelectOption(cat, val) {
      Vue.set(this.selected, cat, val);
      Vue.set(this.filter, cat, val);

      this.__saveStateFilters();
      this.$emit('change', this.filter);
    },

    onClear() {
      _.keysIn(this.selected).forEach((key) => {this.selected[key] = null});
      _.keysIn(this.filter).forEach((key) => {this.filter[key] = null});

      this.$emit('change', this.filter);
    },

    __saveStateFilters() {
      this.$store.dispatch('interface/saveFilterPlugins', {
        special:          this.special,
        saveSpecialState: this.saveSpecialState,
        selected:         this.selected,
        filter:           this.filter,
      });
    }
  },

  computed: {
    isFilterSelected() {
      console.log(this.filter)
      return _.valuesIn(this.selected).reduce((accum, val) => {return accum ? accum : val !== null}, false);
    },

    filterStore() {
      return this.$store.getters['interface/filterPlugins'];
    }
  },

  watch: {
    filterStore(val) {
      if('special' in this.filterStore)
        Vue.set(this, 'special',          this.filterStore.special);
      if('saveSpecialState' in this.filterStore)
        Vue.set(this, 'saveSpecialState', this.filterStore.saveSpecialState);
      if('selected' in this.filterStore)
        Vue.set(this, 'selected',         this.filterStore.selected);
      if('filter' in this.filterStore)
        Vue.set(this, 'filter',           this.filterStore.filter);
    }
  }
}
</script>

<style lang="scss" scoped>
  .mega-filter {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .filter-grid-and-mode {
    display: flex;
    flex: 0 0 auto;
  }

  .grid-menu {
    flex: 0 0 auto;
  }

  .filter-mode {
    margin: 6px 6px 0 auto;
    width: 42px;
    flex: 0 0 auto;

    .btn {
      width: 100%;
    }
  }

  .btn-clear {
    height: 65px;
  }

  .filter-categories {
    margin-top: 10px;
    margin-bottom: 10px;
    overflow: auto;
  }

  .filter-options {
    position: relative;
    margin-top: 30px;
    flex: 0 0 auto;

    .category-select {
      margin: 6px;
    }
  }

  .filter-options-shadow-wrap {
    position: absolute;
    top: -5px;
    left: 0;
    right: 0;
    bottom: -5px;
    overflow: hidden;
  }

  .filter-options-shadow {
    position: absolute;
    top: 5px;
    left: 0;
    right: 0;
    bottom: 5px;
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.5);
  }

  .filter-options-content {
    position: relative;
  }
</style>

<style lang="scss">

</style>