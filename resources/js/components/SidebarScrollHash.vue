<template lang="pug">
  .menu
    .group(:class="{widthHalf: }")
</template>

<script>

export default {
  components: {

  },

  data: () => ({

  }),

  computed: {

  },

  methods: {

  }
}
</script>

<style scoped lang="sass">
  .menu
    position: fixed
    top: 0
    right: 0
    bottom: 0
    width: 280px
    background-color: #fff
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5)
    z-index: 1
</style>
