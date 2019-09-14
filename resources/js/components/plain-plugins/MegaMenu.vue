<template lang="pug">


  .megamenu


</template>

<script>

export default {
  name: 'MegaMenu',

  components: {

  },

  props: {
    items: {
      type: Array,
      required: true
    }
  },

  data() {
    return {

    }
  },

  mounted () {

  },

  methods: {
    onChangePage() {
      this.$emit('change-page')
    },
  },
  watch: {

  }
}
</script>

<style lang="scss" scoped>
  .megamenu {

  }
</style>

<style lang="scss">


</style>