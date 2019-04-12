<template lang="pug">
  div.tree-taxonomy-items-edit
    b-button(@click='onAddItem', size='lg', variant='success')
      fa(icon='folder', size='lg')
      | +
    div(v-if="items !== null")
      .list-group(v-if='items.length')
        vue-draggable-nested-tree(:data="items" draggable crossTree ref="tree1" @drag="ondrag" @change="onchange" :space="0" :indent="30")
          div(slot-scope="{data, store}", :key="data.id")
            .card-tax(:class="data.published == 0 ? '__not-publish' : data.not_publish_parent === true ? '__not-publish-parent' : null")
              template(v-if="!data.isDragPlaceHolder")
                button.btn.btn-light.btn-sm.btn-collapse(v-if="data.children && data.children.length" @click="store.toggleOpen(data); onToggle(data)" type='button')
                  fa(v-if="!data.open" :icon="['far', 'plus-square']", size='sm')
                  fa(v-else :icon="['far', 'minus-square']", size='sm')
                span.text-title(:class="{'ml-2': !(data.children && data.children.length)}") {{data.title}}
                .btn-group
                  button.btn.btn-warning.btn-sm.btn-update.ml-1(@click="onUpdate(data)" type='button')
                    span.glyphicon.glyphicon-pencil
                  button.btn.btn-danger.btn-sm.btn-delete(@click="onDelete(data)" type='button')
                    span.glyphicon.glyphicon-remove
      .alert.alert-primary(v-else='', role='alert') Нет категорий!
    div(v-else): h4 Данные пока незагружены
    b-modal#modal-create-category(ref='modal-create-category', title='Добавить категорию', hide-footer='')
      form(@submit.prevent='addItem', @keydown='addForm.onKeydown($event)', action='', method='post')
        // Title
        .form-group.row
          label.col-md-3.col-form-label.text-md-right {{ 'Заголовок' }}
          .col-md-7
            input.form-control(v-model='addForm.title', :class="{ 'is-invalid': addForm.errors.has('title') }", type='text', name='title')
            has-error(:form='addForm', field='title')
        // Slug
        .form-group.row
          label.col-md-3.col-form-label.text-md-right {{ $t('slug') }}
          .col-md-7
            input.form-control(v-model='addForm.slug', :class="{ 'is-invalid': addForm.errors.has('slug') }", type='text', name='slug')
            has-error(:form='addForm', field='slug')
        // Publish
        .form-group.row
          label.col-12 {{ $t('publish') }}
          .col-12
            b-form-checkbox(switch v-model='addForm.published' name='published')
            div(:class="{ 'is-invalid': addForm.errors.has('published') }")
            has-error(:form='addForm', field='published')
        .form-group.row
          .col-md-7.offset-md-3.d-flex
            // Submit Button
            v-button(block='', :loading='addForm.busy')
              | Добавить категорию
      template(slot='modal-cancel') Нет
      template(slot='modal-ok') Да
    b-modal#modal-update-category(ref='modal-update-category', :title='\'Обновить категорию "\' + (this.curItem ? this.curItem.title : \'\') + \'"?\'', hide-footer='')
      form(@submit.prevent='updateItem', @keydown='updateForm.onKeydown($event)', action='', method='put')
        // Title
        .form-group.row
          label.col-md-3.col-form-label.text-md-right {{ 'Заголовок' }}
          .col-md-7
            input.form-control(v-model='updateForm.title', :class="{ 'is-invalid': updateForm.errors.has('title') }", type='text', name='title')
            has-error(:form='updateForm', field='title')
        // Slug
        .form-group.row
          label.col-md-3.col-form-label.text-md-right {{ $t('slug') }}
          .col-md-7
            input.form-control(v-model='updateForm.slug', disabled='', :class="{ 'is-invalid': updateForm.errors.has('slug') }", type='text', name='slug')
            has-error(:form='updateForm', field='slug')
        // Publish
        .form-group.row
          label.col-12 {{ $t('publish') }}
          .col-12
            b-form-checkbox(switch v-model='updateForm.published' name='published')
            div(:class="{ 'is-invalid': updateForm.errors.has('published') }")
            has-error(:form='updateForm', field='published')
        .form-group.row
          .col-md-7.offset-md-3.d-flex
            // Submit Button
            v-button(block='', :loading='updateForm.busy')
              | Обновить категорию
      template(slot='modal-cancel') Нет
      template(slot='modal-ok') Да
    b-modal#modal-delete-category(ref='modal-delete-category', title='Точно удалить?')
      template(slot='modal-footer')
        b-button(size='sm', variant='secondary', @click='cancelModal') Нет
        b-button(size='sm', variant='primary', @click='onDeleteItem') Удалить
        b-button(v-if="curItem !== null && 'children' in curItem && curItem.children.length" size='sm', variant='danger', @click='onDeleteItemNested') Удалить с вложенными категориями
    b-modal#modal-delete-category-what-new-parent(ref='modal-delete-category-what-new-parent', title='Куда переместить дочерние элементы?')
      template(slot='modal-footer')
        b-button(size='sm', variant='secondary', @click='cancelModal2') Отмена
        b-button(size='sm', variant='primary', @click='onDeleteItemParentNull') В корень
        b-button(size='sm', variant='primary', @click='onDeleteItemParentNull') В родителя удалённого пункта
</template>

<script>
  import axios from 'axios'
  import * as th from 'tree-helper'

  import {mixin} from './mixin'

  export default {
    name: 'Categories',

    mixins: [mixin],

    props: {

    },

    mounted: function () {

    },

    data() {
      return {
        type: 'categories',
        typeOne: 'category',
        openedItems: {},
      }
    },
    // computed: {},
    // watch: {},
    methods: {
      onchange() {
        var result = []
        ;(function recursion(items, parent_id) {
          items.forEach((item) => {
            result.push({id: item.id, parent_id})
            if('children' in item) {
              recursion(item.children, item.id)
            }
          })
        })(this.items, null)

        axios.put('/api/admin/categories/items-update-tree', {data: result})
      },

      async onDeleteItem () {
        if('children' in this.curItem && this.curItem.children.length) {
          if(this.curItem.parent_id !== null) {
            this.$root.$emit('bv::hide::modal', 'modal-delete-category')
            this.$root.$emit('bv::show::modal','modal-delete-category-what-new-parent')
          } else {
            await axios.delete('/api/admin/categories/' + this.curItem.id, {
              data: {
                new_parent: null
              }
            })
            this.$root.$emit('bv::hide::modal', 'modal-delete-category')
            this.__reloadItems()
          }
        } else {
          await axios.delete('/api/admin/categories/' + this.curItem.id)
          this.$root.$emit('bv::hide::modal', 'modal-delete-category')
          this.__reloadItems()
        }
      },

      async onDeleteItemParentNull () {
        await axios.delete('/api/admin/categories/' + this.curItem.id, {
          data: {
            new_parent: null
          }
        })
        this.__reloadItems()
      },

      async onDeleteItemParentParent () {
        await axios.delete('/api/admin/categories/' + this.curItem.id, {
          data: {
            new_parent: this.curItem.parent_id
          }
        })
        this.__reloadItems()
      },

      async onDeleteItemNested () {
        await axios.delete('/api/admin/categories/' + this.curItem.id, {
          data: {
            delete_children: true
          }
        })

        this.$root.$emit('bv::hide::modal', 'modal-delete-category')

        this.__reloadItems()
      },

      cancelModal () {
        this.$root.$emit('bv::hide::modal', 'modal-delete-category')
      },

      cancelModal2 () {
        this.$root.$emit('bv::hide::modal', 'modal-delete-category-what-new-parent')
      },

      __flatToTreeArray(arr) {
        var r = []
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
        return r;
      },

      __setNotPublishParent(arr, not_publish) {
        arr.forEach((a) => {
          if(not_publish === true) {
            a.not_publish_parent = true
          }
          if(a.children && a.children.length) {
            this.__setNotPublishParent(a.children, not_publish === true || a.published == 0)
          }
        })
      },

      onToggle (e) {
        this.openedItems[e.id] = e.open
      },

      __setOpenedItems (data) {
        data.forEach((item) => {
          item.open = this.__itemOpened(item.id)
        })
      },

      __itemOpened (id) {
        if(!(id in this.openedItems)) {
          return false
        }

        return this.openedItems[id]
      }
    },
    // created() {},
    // mounted() {},
  }
</script>

<style lang="sass">
  .tree-taxonomy-items-edit
    .text-title
      display: inline-block
      margin: 3px 0
    .btn-update,
    .btn-delete
      display: none
    //.tree-node-inner
    .card-tax
      border: none
      border-bottom: 1px solid #ccc
      padding-right: 10px
      backgroud: #ccc
    .card-tax.__not-publish
      opacity: 0.5
    .card-tax.__not-publish-parent
      border-bottom-style: dashed
    .tree-node-inner:hover .btn-update,
    .tree-node-inner:hover .btn-delete
      display: inline-block
    .btn,
    .btn:focus,
    .btn.focus
      outline: none
      box-shadow: none
</style>