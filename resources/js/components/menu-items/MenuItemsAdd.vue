<template lang="pug">
  div
    div.list-menu-item(v-for="(item, index) in Array(3)")
      menu-item(:data="{type_id: index + 1}" :edit="false" :menuId="menuId" @store="onStore")
</template>

<script>
  import * as th from 'tree-helper'
  import MenuItem from "./MenuItem"

  export default {
    name: 'MenuItemsAdd',

    props: {
      items: {
        type: Array,
        default: []
      },
      menuId: {
        type: Number,
        required: true
      },
    },

    components: {
      'menu-item': MenuItem,
    },

    data() {
      return {

      }
    },
    // computed: {},
    // watch: {},
    methods: {
      onStore () {
        this.$emit('store')
      }
    },
    // created() {},
    // mounted() {},
  }
</script>

<style lang="sass" scoped>
  .list-menu-item
    margin-bottom: 5px
</style>