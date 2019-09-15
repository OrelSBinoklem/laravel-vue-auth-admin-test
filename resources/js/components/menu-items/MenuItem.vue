<template lang="pug">
  .menu-item(:class="{__open: !!data.open}")
    button.btn-uncollapsed(
      v-if="edit"
      type="button",
      @click="onClickUncollapsed",
      v-on:mousemove.stop="", v-on:mouseover.stop="", v-on:mouseout.stop="")
      template(v-if="!!data.children && !!data.children.length")
        fa(v-if="!data.open" :icon="['far', 'plus-square']")
        fa(v-else :icon="['far', 'minus-square']")

    .card.border-secondary(:class="data.publish == 0 ? '__not-publish' : data.not_publish_parent === true ? '__not-publish-parent' : null")
      .card-header(v-if="!__isPlaceholder()") {{edit ? data.name : type}}
        small.text-muted(v-if="edit") {{type}}
        button.__edit(
          type="button",
          @click="onClick",
          :class="isCollapsed ? '__open' : null",
          v-on:mousemove.stop="", v-on:mouseover.stop="", v-on:mouseout.stop="")
          fa(icon="caret-down")

      template(v-if="!__isPlaceholder()")
        b-collapse(v-model="isCollapsed", :id="edit ? 'collapse-' + data.id : 'collapse-item-edit' + data.type_id")
          .card-body(v-on:mousemove.stop="", v-on:mouseover.stop="", v-on:mouseout.stop="")
            .row.justify-content-end
              .col-6
                // Name
                .form-group.row
                  label.col-12 Текст ссылки
                  .col-12
                    input.form-control.form-control-sm(v-model='form.name', :class="{ 'is-invalid': form.errors.has('name') }", type='text', name='name')
                    has-error(:form='form', field='name')
              .col-6
                // Slug
                .form-group.row
                  label.col-12 {{ $t('slug') }}
                  .col-12
                    input.form-control.form-control-sm(v-model='form.slug', :disabled="edit", :class="{ 'is-invalid': form.errors.has('slug') }", type='text', name='slug')
                    has-error(:form='form', field='slug')
              .col-6
                // Publish
                .form-group.row
                  label.col-12 {{ $t('publish') }}
                  .col-12
                    b-form-checkbox(switch v-model='form.publish' name='publish')
                    div(:class="{ 'is-invalid': form.errors.has('publish') }")
                    has-error(:form='form', field='publish')
            component(v-bind:is="component" v-bind="{data: data, edit: edit, form: form}")
          .card-footer
            .btn-toolbar.justify-content-end
              .btn-group.mr-auto(v-if="edit")
                button.btn.btn-danger(@click='onDeleteItem', type='button')
                  fa(:icon="['far', 'trash-alt']", size='lg')
              .btn-group.ml-2(v-if="!edit")
                button.btn.btn-success(@click='onAddItem', type='button')
                  fa(icon='plus', size='lg')
              .btn-group.ml-2(v-if="edit")
                button.btn.btn-success(@click='onUpdateItem', type='button')
                  fa(:icon="['far', 'save']", size='lg')
</template>

<script>
  import Form from 'vform'
  import axios from 'axios'

  import {types} from "./types-data"

  import Casual from "./casual/Casual"
  import {metaFields as casualMetaFields, setMetaFields as casualSetMetaFields} from "./casual/meta-fields"
  import SingleMaterial from "./single-material/SingleMaterial"
  import {metaFields as singleMaterialMetaFields, setMetaFields as singleMaterialSetMetaFields} from "./single-material/meta-fields"
  import Category from "./category/Category"
  import {metaFields as categoryMetaFields, setMetaFields as categorySetMetaFields} from "./category/meta-fields"

  export default {
    name: 'MenuItem',

    props: {
      data: {
        type: Object,
        required: true
      },
      edit: {
        type: Boolean,
        required: true
      },
      menuId: {
        type: Number,
        required: true
      },
      collapsed: {
        type: Boolean,
        default: false
      }
    },

    components: {
      'Casual': Casual,
      'SingleMaterial': SingleMaterial,
      'Category': Category
    },

    beforeMount() {
      if(this.edit && !this.__isPlaceholder()) {
        this.form.name = this.data.name
        this.form.slug = this.data.slug
        this.form.publish = !!this.data.publish

        this.__setMetaFields()

        this.isCollapsed = this.collapsed
      }
    },

    mounted() {

    },

    data() {
      return {
        form: (() => {
          if (!this.__isPlaceholder()) {
            return new Form({
              name: '',
              slug: '',
              publish: true,

              type_id: this.data.type_id,

              ...this.__getMetaFields()
            })
          }
        })(),
        isCollapsed: false
      }
    },

    computed: {
      component: function () {
        if(this.data.type_id in types) {
          return types[this.data.type_id].component
        } else {
          throw new Error('Нет такого типа пунктов меню')
        }
      },

      type: function () {
        if(this.data.type_id in types) {
          return types[this.data.type_id].typeName
        } else {
          throw new Error('Нет такого типа пунктов меню')
        }
      }
    },

    //watch: {},
    methods: {
      async onAddItem () {
        await this.form.post('/api/admin/menus/' + (this.menuId) + '/items')

        this.$emit('store')
      },

      async onUpdateItem () {
        await this.form.put('/api/admin/menus/' + (this.menuId) + '/items/' + this.data.id)

        this.$emit('update')
      },

      async onDeleteItem () {
        this.$emit('delete', {
          hasNested: !!('children' in this.data && this.data.children.length),
          hasParent: this.data.parent_id !== null,
          parent_id: this.data.parent_id,
          menu_id: this.menuId,
          item_id: this.data.id,
        })
      },

      onClick () {
        this.isCollapsed = !this.isCollapsed

        this.$emit('toggle', {
          id: this.data.id,
          collapsed: this.isCollapsed
        })
      },

      onClickUncollapsed() {
        this.data.open = !this.data.open;
      },

      __getMetaFields () {
        switch(this.data.type_id) {
          case 1:
            return casualMetaFields
          case 2:
            return singleMaterialMetaFields
          case 3:
            return categoryMetaFields
          default:
            throw new Error('Нет такого типа пунктов меню')
            break
        }
      },

      __setMetaFields () {
        switch(this.data.type_id) {
          case 1:
            casualSetMetaFields(this.form, this.data)
            break
          case 2:
            singleMaterialSetMetaFields(this.form, this.data)
            break
          case 3:
            categorySetMetaFields(this.form, this.data)
            break
          default:
            throw new Error('Нет такого типа пунктов меню')
            break
        }
      },

      __isPlaceholder () {
        return 'isDragPlaceHolder' in this.data
      }
    },
    // created() {},
    mounted() {
      console.log(this.data);
    }
  }
</script>

<style scoped lang="sass">
  .menu-item
    position: relative

  .btn-uncollapsed
    display: block
    position: absolute
    top: 0
    right: 100%
    width: 30px
    height: 100%
    border: none
    outline: none
    background: transparent
    cursor: pointer
  .btn-uncollapsed:hover
    background-color: #eee
  .btn-uncollapsed svg
    position: relative
    background-color: #F7F9FB

  .card
    min-height: 37px
  .card.__not-publish
    opacity: 0.5
  .card.__not-publish-parent
    border-style: dashed
  .card-header
    position: relative
    padding: 0.4rem 0.5rem
  .card-body
    padding: 0.5rem
  .__edit
    display: block
    position: absolute
    top: 0
    right: 0
    width: 35px
    height: 100%
    border: none
    outline: none
    background: transparent
    cursor: pointer
  .__edit:hover
    background-color: #eee
  .__edit svg
    transition: transform 0.2s linear
  .__edit.__open svg
    transform: scaleY(-1)
  .card-header small
    position: absolute
    top: 9px
    right: 35px

  .card
    h1
      font: 18px/22px Arial, sans-serif
      color: #333333
    a
      font: 16px/18px Tahoma, sans-serif
      text-decoration: none
</style>