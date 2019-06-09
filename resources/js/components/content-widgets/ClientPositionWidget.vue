<!--todo-orel Както убрать ебаный div-->
<template lang="pug">
  div
    template(v-if="data.widgets" v-for="(widget, index) in data.widgets")
      component(v-bind:is="widget.name" v-bind="widget.props")
        template(v-if="widget.positions" v-for="(position, name) in widget.positions" :slot="name")
          ClientPositionWidget(:data="position")
</template>

<script>
  import alert from './alert/Client'

  export default {
    name: "ClientPositionWidget",

    components: {
      alert
    },

    props: {
      data: {
        type: Object,
        required: true
      }
    },

    beforeMount() {

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

</style>