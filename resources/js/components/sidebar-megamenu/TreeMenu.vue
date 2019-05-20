<template lang="pug">
  .tree-menu
    ul(data-level="0")
      TreeSubItem(v-for='item in items', :item='item' :level="0" :key="item.id")
</template>

<script>

import TreeSubItem from './TreeSubItem';

export default {
  name: 'TreeMenu',

  components: {
    TreeSubItem
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

  },
  watch: {

  }
}
</script>

<style lang="sass" scoped>

</style>

<style lang="sass">
  .tree-menu
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
    [data-level='0'] > li > .item-data
      margin-left: -10px
      padding: 0 0 0 10px
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
      font-size: 14px
    //level 2
    [data-level='2']
      display: none
      position: absolute
      left: 100%
      top: -10px
      margin-top: 0
      margin-bottom: 0
      padding-top: 8px
      padding-bottom: 8px
      min-width: 280px
      background: #fff
      box-shadow: 1px 1px 5px 0 rgba(0, 0, 0, 0.5)
      border-top: 2px solid #007bff
      border-bottom: 2px solid #007bff
      border-radius: 5px
    [data-level='2'] > li > .item-data
      margin-left: -10px
      padding-left: 10px
      padding-right: 10px
    [data-level='2'] .item-data a
      white-space: nowrap
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