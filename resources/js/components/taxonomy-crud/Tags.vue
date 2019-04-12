<template lang="pug">
  div.tag-items-edit
    b-button(@click='onAddItem', size='lg', variant='success')
      fa(icon='tag', size='lg')
      | +
    .row(v-if="items !== null")
      .col-6(v-for="item in items" :key="item.id")
        .card-tag(:class="item.published == 0 ? '__not-publish' : null")
          span.text-title {{item.title}}
          .btn-group
            button.btn.btn-warning.btn-sm.btn-update.ml-1(@click="onUpdate(item)" type='button')
              span.glyphicon.glyphicon-pencil
            button.btn.btn-danger.btn-sm.btn-delete(@click="onDelete(item)" type='button')
              span.glyphicon.glyphicon-remove
    div(v-else): h4 Данные пока незагружены
    b-modal#modal-create-tag(ref='modal-create-tag', title='Добавить тэг', hide-footer='')
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
            v-button(block='', :loading='addForm.busy') Добавить тэг
      template(slot='modal-cancel') Нет
      template(slot='modal-ok') Да
    b-modal#modal-update-tag(ref='modal-update-tag', :title='\'Обновить тэг "\' + (this.curItem ? this.curItem.title : \'\') + \'"?\'', hide-footer='')
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
            v-button(block='', :loading='updateForm.busy') Обновить тэг
      template(slot='modal-cancel') Нет
      template(slot='modal-ok') Да
    b-modal#modal-delete-tag(ref='modal-delete-tag', title='Точно удалить?')
      template(slot='modal-footer')
        b-button(size='sm', variant='secondary', @click='cancelModal') Нет
        b-button(size='sm', variant='primary', @click='onDeleteItem') Удалить
</template>

<script>
  import axios from 'axios'
  import * as th from 'tree-helper'

  import {mixin} from './mixin'

  export default {
    name: 'Tags',

    mixins: [mixin],

    props: {

    },

    mounted: function () {

    },

    data() {
      return {
        type: 'tags',
        typeOne: 'tag'
      }
    },
    // computed: {},
    // watch: {},
    methods: {
      async deleteItem () {
        await axios.delete('/api/admin/categories/' + this.curItem.id)
        this.$root.$emit('bv::hide::modal', 'modal-delete-tag')
        this.__reloadItems()
      },

      cancelModal () {
        this.$root.$emit('bv::hide::modal', 'modal-delete-tag')
      },

      async onDeleteItem () {
        await axios.delete('/api/admin/tags/' + this.curItem.id)
        this.$root.$emit('bv::hide::modal', 'modal-delete-tag')
        this.__reloadItems()
      }
    },
    // created() {},
    // mounted() {},
  }
</script>

<style lang="sass">
  .tree-menu-items-edit
    .tree-node-inner-back
      box-sizing: content-box
      width: calc(100% - 60px)
</style>