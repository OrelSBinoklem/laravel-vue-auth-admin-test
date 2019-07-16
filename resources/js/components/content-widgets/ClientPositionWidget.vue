<!--todo-orel Както убрать ебаный div-->
<template lang="pug">
  div
    template(v-if="data.widgets" v-for="(widget, index) in data.widgets")
      //todo зделать управление вложенными виджетами через контекст или стор (убрать передачу пропса positions)
      component(v-bind:is="widget.name" v-bind="__getMergeProps(widget.props, {positions: widget.positions})")
        template(v-if="widget.positions" v-for="(position, name) in widget.positions" :slot="name")
          ClientPositionWidget(:data="position")
</template>

<script>
  import alert from './alert/Client'
  import callout from './callout/Client'
  import casual_html from './casual_html/Client'
  import code_editor from './code_editor/Client'
  import copy_code from './copy_code/Client'

  export default {
    name: "ClientPositionWidget",

    components: {
      alert,
      callout,
      casual_html,
      code_editor,
      copy_code
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
      __getMergeProps(a, b) {
        return {...a, ...b}
      }
    },

    watch: {

    }
  }
</script>

<style lang="sass" scoped>

</style>