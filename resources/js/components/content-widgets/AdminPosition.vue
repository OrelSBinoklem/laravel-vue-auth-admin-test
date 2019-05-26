<template lang="pug">
  .position
</template>

<script>

  export default {
    name: "AdminPosition",

    components: {

    },

    props: {
      edit: {
        type: Boolean,
        required: true
      },

      form: {
        type: Form,
        required: true
      },

      data: {
        type: Object,
        required: true
      },

      prefixDataForm: {
        type: String,
        required: true
      }
    },

    beforeMount() {
      if(!this.edit) {

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

<style lang="sass" scoped>
  .position
    min-width: 10px
    min-height: 10px
    outline: 1px dashed red
    outline-offset: -1px
</style>