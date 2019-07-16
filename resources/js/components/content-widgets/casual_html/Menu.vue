<template lang="pug">
  span(v-if="!megamenu" @click="onClick") Простой HTML
  .row(v-else)
    .col-12
      h3(@click="onClick") Простой HTML
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
            name: 'casual_html',
            props: {
              html: ''
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