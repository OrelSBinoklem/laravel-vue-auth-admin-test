<template lang="pug">
  .row
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

  export default {
    name: "Client",

    components: {

    },

    props: {

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

<style>

</style>