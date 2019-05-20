<template lang="pug">
  .row
    .col-6
      // Material
      .form-group.row
        //todo-orel перевести
        label.col-12 Материал
        .col-12
          b-button(variant='outline-dark' @click="openSelectCategory = true" block) {{categoryTitle || 'Выберите категорию'}}
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has('category') }")
          has-error(:form='form', field='category')
    SelectCategory(:open.sync="openSelectCategory" @select="onSelectCategory")
</template>

<script>
  import _ from 'lodash'
  import { mapGetters } from 'vuex'
  import Form from 'vform'
  import SelectCategory from "./SelectCategory"

  export default {
    name: "SingleMaterial",

    components: {
      'SelectCategory': SelectCategory
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
      openSelectCategory: false
    }),

    computed: {
      ...mapGetters({
        categories: 'db/categories'
      }),

      categoriesByKeysSlugs() {
        return this.categories !== null ? _.keyBy(this.categories, 'slug') : null
      },

      categoryTitle() {
        if(
          this.categories !== null
          && this.form.category_slug in this.categoriesByKeysSlugs
        ) {
          return this.categoriesByKeysSlugs[this.form.category_slug].title
        }
        return this.form.category_slug === null ? null : 'Slug:' + this.form.category_slug
      }
    },

    methods: {
      onSelectCategory (e) {
        this.form.category_slug = e.slug
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>