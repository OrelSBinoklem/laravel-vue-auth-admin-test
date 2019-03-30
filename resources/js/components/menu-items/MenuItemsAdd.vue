<template lang="pug">
  div
    div(v-for="(item, index) in Array(1)")
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

<style lang="sass">

</style>