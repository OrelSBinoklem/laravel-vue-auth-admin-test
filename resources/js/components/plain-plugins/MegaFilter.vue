<template lang="pug">


  .mega-filter

    .filter-grid-and-mode
      .grid-menu
        grid-menu(:data="data.gridMenu" @select="onSelectGridMenu" mode="compact")
      .filter-mode

    .filter-categories
      vue-scroll(:ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}")
        categories-tree(:root-category="data.categoriesMenuSlug" @checked-and-intermediate="onChangeCat")

    .filter-options
      .filter-options-shadow-wrap: .filter-options-shadow
      .filter-options-content
        category-select(v-for="opt in data.options" @select="(val) => {onSelectOption(opt.rootCategory, val)}" :root-category="opt.rootCategory" :default-text="opt.defText" :key="opt.rootCategory")


</template>

<script>

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
      selected: {
        framework: null,
        code_type: null,

        categories: null
      }
    }
  },

  computed: {

  },

  mounted () {

  },

  methods: {
    onSelectGridMenu(val) {
      this.selected.framework = val.row === 'all' || val.row === null ? null : this.data.gridMenu.rows[val.row].slug;
      this.selected.code_type = val.col === 'all' || val.col === null ? null : this.data.gridMenu.cols[val.col].slug;
      this.$emit('change', this.selected);
    },

    onChangeCat(categories) {
      this.selected.categories = !!categories ? categories.map(cat => cat.slug) : null;
      this.$emit('change', this.selected);
    },

    onSelectOption(cat, val) {
      this.selected[cat] = val;
      this.$emit('change', this.selected);
    }
  },

  watch: {

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
    /*width: 118px; если надо квадратные кнопки а не прямоугольные*/
    width: 70px;
    flex: 0 0 auto;
  }

  .filter-categories {
    margin-top: 10px;
    margin-bottom: 10px;
    overflow: auto;
  }

  .filter-options {
    position: relative;
    margin-top: auto;
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
    bottom: 0;
    overflow: hidden;
  }

  .filter-options-shadow {
    position: absolute;
    top: 5px;
    left: 0;
    right: 0;
    bottom: 0;
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.5);
  }

  .filter-options-content {
    position: relative;
  }
</style>

<style lang="scss">

</style>