<template lang="pug">
  li(:class="{'level-2-category': level === 2 && item.type_id === 3}")
    .item-data
      router-link(v-if='item.is_router', :to='__getRouterData(item)', active-class='active'): span(@click="onChangePage") {{ item.name }}
      a(v-else='', :href='item.path' @click="onChangePage") {{ item.name }}
    //transition(name="slide-fade")
    ul(v-if="item.children && item.children.length" :data-level="level + 1")
      MegaMenuSubItem(v-for="node in item.children" :item="node" :level="level + 1" :key="node.id" @change-page="onChangePage")
</template>

<script>

export default {
  name: 'MegaMenuSubItem',

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
    onChangePage() {
      this.$emit('change-page')
    },

    __getRouterData(item) {
      return {...item.router}
    }
  },
  watch: {

  }
}
</script>

<style lang="sass" scoped>

</style>
