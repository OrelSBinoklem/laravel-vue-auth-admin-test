<template lang="pug">
  span(v-if="!megamenu" @click="onClick") Копирование кода
  .row(v-else)
    .col-12
      h3(@click="onClick") Копирование кода
</template>

<script>
  import {mixinMenu} from '../mixinMenu'

  export default {
    name: "Menu",

    mixins: [mixinMenu],

    components: {

    },

    props: {
      megamenu: {
        type: Boolean,
        required: true
      }
    },

    data: () => ({

    }),

    computed: {

    },

    methods: {
      onClick() {
        if(this.current !== null) {
          this.current.widgets.push({
            name: 'copy_code',
            props: {
              type_visible: null,
              getter_store_priority_type_code: 'interface/priorityCopyTypeCode',
              count_editors: 1,
              min_lines: 10,
              max_lines: 10,
              editors: [{heading: 'Редактор 1', variant_or_group: 'html'}]
            },
            positions: {
              editor0: {
                data: {
                  name: 'Редактор 1'
                },
                rules: [
                  {
                    name: /^code_editor$/gmi,
                    count: '1-5'
                  }
                ],
                widgets: [{
                  name: 'code_editor',
                  props: {
                    variant: 'html',
                    min_lines: 10,
                    max_lines: 10,
                    code: ''
                  }
                }]
              }
            }
          })
        }
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>