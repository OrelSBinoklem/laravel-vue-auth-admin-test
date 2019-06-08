<template lang="pug">
  b-alert(:variant='variant' v-html="html" show)
</template>

<script>
  import {mixinClient} from '../mixinClient'

  export default {
    name: "Client",

    mixins: [mixinClient],

    components: {

    },

    props: {
      props: {
        variant: {
          type: String,
          required: true
        },

        html: {
          type: String,
          required: true
        }
      },
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