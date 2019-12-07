<template lang="pug">
  .markdown
    vue-markdown {{code}}
</template>

<script>
  import {mixinClient} from '../mixinClient'

  import VueMarkdown from 'vue-markdown'

  export default {
    name: "Client",

    mixins: [mixinClient],

    components: {
      VueMarkdown
    },

    props: {
      code: {
        type: String,
        required: true
      }
    },

    data: () => ({

    }),

    mounted () {

    },

    computed: {

    },

    methods: {

    },

    watch: {

    }
  }
</script>

<style scoped lang="scss">
  .markdown {
    margin: 15px 0;
  }
</style>