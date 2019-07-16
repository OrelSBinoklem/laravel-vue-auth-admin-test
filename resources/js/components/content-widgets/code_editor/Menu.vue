<template lang="pug">
  span(v-if="!megamenu" @click="onClick") Редактор кода
  .row(v-else)
    .col-12
      h3(@click="onClick") Редактор кода
</template>

<script>
  import {mixinMenu} from '../mixinMenu'

  export default {
    name: "Menu",

    mixins: [mixinMenu],

    components: {

    },

    props: {
      megamenu: {
        type: Boolean,
        required: true
      }
    },

    data: () => ({

    }),

    computed: {

    },

    methods: {
      onClick() {
        if(this.current !== null) {
          this.current.widgets.push({
            name: 'code_editor',
            props: {
              variant: 'html',
              min_lines: 10,
              max_lines: 10,
              code: ''
            }
          })
        }
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>