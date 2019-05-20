<template lang="pug">
  .row
    .col-6
      // Type Material
      .form-group.row
        //todo-orel перевести
        label.col-12 Тип материала
        .col-12
          b-form-select(:value="form.content_type" @input="form.content_type = $event; form.material_slug = null" :options="content_type_list" name='content_type')
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has('content_type') }")
          has-error(:form='form', field='content_type')
    .col-6
      // Material
      .form-group.row
        //todo-orel перевести
        label.col-12 Материал
        .col-12
          b-button(variant='outline-dark' :disabled="form.content_type === null" @click="openSelectMaterial = true" block) {{materialTitle || 'Выберите материал'}}
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has('material_slug') }")
          has-error(:form='form', field='material_slug')
    SelectMaterial(:content_type="form.content_type" :open.sync="openSelectMaterial" @select="onSelectMaterial")
</template>

<script>
  import { mapGetters } from 'vuex'
  import Form from 'vform'
  import {contentTypes} from "../../content-types/contentTypes";
  import SelectMaterial from "./SelectMaterial"

  export default {
    name: "SingleMaterial",

    components: {
      'SelectMaterial': SelectMaterial
    },

    props: {
      data: {
        type: Object
      },
      edit: {
        type: Boolean,
        required: true
      },
      form: {
        type: Form,
        required: true
      },
    },

    data: () => ({
      contentTypes: contentTypes.get().contentTypes,
      openSelectMaterial: false
    }),

    computed: {
      content_type_list() {
        //todo-orel перевести
        var r = [{ value: null, text: 'Выберите тип материала' }]
        this.contentTypes.forEach((el) => {
          r.push(
            {
              value: el.slug,
              text: el.name
            }
          )
        })
        return r
      },

      ...mapGetters({
        materials: 'menu/adminMaterials'
      }),

      materialTitle() {
        if(
          this.materials !== null
          && this.form.content_type in this.materials
          && this.form.material_slug in this.materials[this.form.content_type]
        ) {
          return this.materials[this.form.content_type][this.form.material_slug].title
        }
        return this.form.material_slug === null ? null : 'Slug:' + this.form.material_slug
      }
    },

    methods: {
      onSelectMaterial (e) {
        this.form.material_slug = e.slug
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>