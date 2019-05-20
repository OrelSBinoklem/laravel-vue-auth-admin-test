<template lang="pug">
  div
    //todo-orel перевод
    b-modal#modal-select-category(:visible="open" @change="onChange" ref='modal-select-category', title='Выберите категорию', hide-footer='')
      // Категории
      .row
        .col
          div(v-for='(cat, index) in categoriesWithIndent', :key='cat.id')
            label(:style="{paddingLeft: (cat.indent * 30) + 'px'}")
              b-form-radio-group(:checked='selected' @input='onSelect')
                b-form-radio(:value='cat.id') {{ cat.title }}
      template(slot='modal-cancel') Нет
      template(slot='modal-ok') Да
</template>

<script>
  import _ from 'lodash'
  import Form from 'vform'
  import moment from 'moment'
  import { mapGetters } from 'vuex'

  export default {
    name: "SelectCategory",
    props: {
      open: {
        type: Boolean,
        required: true
      }
    },

    data: () => ({
      selected: ''
    }),

    computed: {
      ...mapGetters({
        categories: 'db/categories'
      }),

      categoriesWithIndent() {
        return this.categories !== null ? this.__setTreeIndent(this.categories) : null
      }
    },

    methods: {
      onChange (e) {
        this.$emit('update:open', e)
      },

      onSelect(val){
        this.selected = val
        this.$emit('select', _.find(this.categories, {id: val}))
      },

      __setTreeIndent(arr) {
        var r = []
        //отсортированные по дереву вложенности - вначали превращаем в дерево потом вживляем отступ а потом делаем плоским но порядок от дерева сохраняеться...
        var sortedAndIndentFlat = []
        arr.forEach(function (a) {
          if(this[a.id]) {
            this[a.id] = {...this[a.id], ...a}
          } else {
            this[a.id] = {...a}
          }

          if (a.parent_id === null) {
            r.push(this[a.id])
          } else {
            this[a.parent_id] = this[a.parent_id] || {}
            this[a.parent_id].children = this[a.parent_id].children || []
            this[a.parent_id].children.push(this[a.id])
          }
        }, Object.create(null))

        recursion(r, 0)

        function recursion(arr, indent) {
          for(let el of arr) {
            sortedAndIndentFlat.push(el)
            el.indent = indent
            if('children' in el && el.children.length) {
              recursion(el.children, indent + 1)
            }
          }
        }

        return sortedAndIndentFlat;
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>