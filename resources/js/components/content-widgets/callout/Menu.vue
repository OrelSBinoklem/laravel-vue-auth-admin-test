<template lang="pug">
  span(v-if="!megamenu" @click="onClick('info')") Callout
  .row(v-else)
    .col-4(@click="onClick('danger')")
      .bs-callout.bs-callout-danger
        h4 Заголовок компонента "Выноски"
        p Lorem ipsum dolor sit amet. Consectetur, adipisci velit, sed ut perspiciatis, unde omnis dolor. Maiores alias consequatur aut rerum necessitatibus.
    .col-4(@click="onClick('warning')")
      .bs-callout.bs-callout-warning
        h4 Заголовок компонента "Выноски"
        p Lorem ipsum dolor sit amet. Consectetur, adipisci velit, sed ut perspiciatis, unde omnis dolor. Maiores alias consequatur aut rerum necessitatibus.
    .col-4(@click="onClick('info')")
      .bs-callout.bs-callout-info
        h4 Заголовок компонента "Выноски"
        p Lorem ipsum dolor sit amet. Consectetur, adipisci velit, sed ut perspiciatis, unde omnis dolor. Maiores alias consequatur aut rerum necessitatibus.
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
      onClick(variant) {
        if(this.current !== null) {
          this.current.widgets.push({
            name: 'callout',
            props: {
              variant,
              heading: '',
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