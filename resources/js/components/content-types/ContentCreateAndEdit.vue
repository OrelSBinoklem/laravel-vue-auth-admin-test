<template lang="pug">
  div
    component(v-if="show" v-bind:is="componentShow" v-bind="{type}")
    component(v-else @updated="onUpdated" v-bind:is="componentCreateAndEdit" v-bind="{edit, data: editData}")
</template>

<script>
  import axios from 'axios'
  import _ from 'lodash'

  import TypeJSPluginShow from './js-plugin/ShowTable'
  import TypeJSPluginCreateAndEdit from './js-plugin/CreateAndEdit'

  export default {
    name: 'ContentCreateAndEdit',

    props: {
      type: {
        type: Object,
        required: true
      },
      editData: {
        type: Object
      },
      edit: {
        type: Boolean,
        required: true
      },
      show: {
        type: Boolean,
        required: true
      },
    },

    components: {
      'type-js-plugin-show': TypeJSPluginShow,
      'type-js-plugin-create-and-edit': TypeJSPluginCreateAndEdit
    },

    data() {
      return {
        data: {}
      }
    },
    computed: {
      componentShow: function () {
        return 'type-' + this.type.component + '-show'
      },
      componentCreateAndEdit: function () {
        return 'type-' + this.type.component + '-create-and-edit'
      },
    },
    // watch: {},
    methods: {
      onUpdated (e) {
        this.$emit('updated', e)
      }
    },
    // created() {},
    // mounted() {},
  }
</script>

<style lang="sass">

</style>