<template lang="pug">
  div(v-html="html")
</template>

<script>
  import {mixinClient} from '../mixinClient'

  export default {
    name: "Client",

    mixins: [mixinClient],

    components: {

    },

    props: {
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