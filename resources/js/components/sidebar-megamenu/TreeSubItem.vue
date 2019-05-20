<template lang="pug">
  li(:class="{'level-2-category': level === 2 && item.type_id === 3}")
    .item-data
      router-link(v-if='item.is_router', :to='__getRouterData(item)', active-class='active') {{ item.name }}
      a(v-else='', :href='item.path') {{ item.name }}
      fa(v-if="item.children && item.children.length && level === 1" icon="chevron-right" size="sm" class="icon-chevron-right")
    //transition(name="slide-fade")
    ul(v-if="item.children && item.children.length" :data-level="level + 1")
      TreeSubItem(v-for="node in item.children" :item="node" :level="level + 1" :key="node.id")
</template>

<script>

export default {
  name: 'TreeSubItem',

  components: {

  },

  props: {
    item: {
      type: Object,
      required: true
    },
    level: {
      type: Number
    }
  },

  data() {
    return {

    }
  },

  mounted () {

  },

  methods: {
    __getRouterData(item) {
      return {...item.router}
    }
  },
  watch: {

  }
}
</script>

<style lang="sass" scoped>
  //.slide-fade-enter-active
    transition: opacity .3s ease, transform .3s ease
  //.slide-fade-leave-active
    transition: opacity 0s ease, transform 0s ease
  //.slide-fade-enter, .slide-fade-leave-to
    transform: translateX(-10px)
    opacity: 0
</style>
