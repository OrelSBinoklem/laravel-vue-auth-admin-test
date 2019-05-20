<template lang="pug">
  .megamenu
    ul(data-level="0")
      MegaMenuSubItem(v-for='item in items', :item='item' :level="0" :key="item.id" @change-page="onChangePage")
</template>

<script>

import MegaMenuSubItem from './MegaMenuSubItem';

export default {
  name: 'MegaMenu',

  components: {
    MegaMenuSubItem
  },

  props: {
    items: {
      type: Array,
      required: true
    }
  },

  data() {
    return {

    }
  },

  mounted () {

  },

  methods: {
    onChangePage() {
      this.$emit('change-page')
    },
  },
  watch: {

  }
}
</script>

<style lang="sass" scoped>

</style>

<style lang="sass">
  .megamenu
    margin: 30px 0
    line-height: 1.3
    ul
      list-style: none
      margin: 0
      padding: 0 0 0 10px
    ul ul
      margin-top: 5px
      margin-bottom: 5px
    ul a
      color: #333
    //level 0
    [data-level='0']
      column-count: 4
      column-gap: 15px
    [data-level='0'] > li
      margin-bottom: 20px
      display: inline-block
      width: 100%
    [data-level='0'] > li > .item-data
      padding: 2px 0 2px 10px
      background-color: rgba(0, 0, 0, .9)
    [data-level='0'] > li > .item-data a
      font-size: 12px
      font-weight: bold
      font-style: italic
      color: #fff
    //level 1
    [data-level='1'] > li
      position: relative
    [data-level='1'] > li:hover [data-level='2']
      display: block
    [data-level='1'] > li > .item-data
      margin-left: -10px
      padding-left: 10px
      display: flex
      align-items: center
    [data-level='1'] > li > .item-data a
      padding-top: 1px
      padding-bottom: 1px
      font-size: 14px
    //level 2
    [data-level='2']
      margin-top: 0
    [data-level='2'] > li > .item-data
      margin-left: -10px
      padding-left: 10px
      padding-right: 10px
    [data-level='2'] .item-data a
      font-size: 12px
    .level-2-category > .item-data a
      font-style: italic
      font-weight: bold
      color: #333
    //level 3
    [data-level='3']
      margin: 0
      padding-left: 0
    .icon-chevron-right
      margin-left: auto
      margin-right: 10px
</style>