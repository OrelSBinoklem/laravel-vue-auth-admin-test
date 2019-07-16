<template lang="pug">
  .bs-callout(:class="'bs-callout-' + variant")
    h4(v-if="heading") {{heading}}
    p(v-html="html")
</template>

<script>
  import {mixinClient} from '../mixinClient'

  export default {
    name: "Client",

    mixins: [mixinClient],

    components: {

    },

    props: {
      variant: {
        type: String,
        required: true
      },

      heading: {
        type: String
      },

      html: {
        type: String,
        required: true
      }
    },

    data: () => ({

    }),

    computed: {

    },

    methods: {

    },

    watch: {

    }
  }
</script>

<style>

</style>