<template lang="pug">


  .mega-filter

    .filter-grid-and-mode
      .grid-menu
        grid-menu(:data="data.gridMenu" @select="onSelectGridMenu")
      .filter-mode

    .filter-categories
      categories-tree(:root-category="data.categoriesMenuSlug" @checked-and-intermediate="onChangeCat")

    .filter-options
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

        categories: null,

        price: null
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
      this.categories = !!categories ? categories.map(cat => cat.slug) : null;
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
  .filter-grid-and-mode {
    display: flex;
  }

  .grid-menu {
    flex-grow: 1;
    flex-basis: 0;
  }

  .filter-mode {
    /*width: 118px; если надо квадратные кнопки а не прямоугольные*/
    width: 70px;
    flex: 0 0 auto;
  }
</style>

<style lang="scss">

</style>