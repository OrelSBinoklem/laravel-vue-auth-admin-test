<template lang="pug">
  span(v-if="!megamenu" @click="onClick") Markdown
  .row(v-else)
    .col-12
      img(src="/img/markdown-logo.png" width="150")
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
            name: 'markdown',
            props: {
              code: 'Hello world!'
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