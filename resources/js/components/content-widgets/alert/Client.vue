<template lang="pug">
  b-alert(
    :id="!!navHash && ((!!navHash.group ? navHash.group + '-' : '') + navHash.slug)"
    :class="{'is-hash': !!navHash}"
    :variant='variant'
    v-html="html"
    show)
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
