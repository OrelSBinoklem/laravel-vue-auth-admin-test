<template lang="pug">
  .row
    .col-6
      // Path
      .form-group.row
        label.col-12 {{ $t('path') }}
        .col-12
          input.form-control.form-control-sm(v-model='form.path', :class="{ 'is-invalid': form.errors.has('path') }", type='text', name='path')
          has-error(:form='form', field='path')
    .col-6
      // Publish
      .form-group.row
        label.col-12 Путь это имя VUE роутера
        .col-12
          b-form-checkbox(switch v-model='form.is_router' name='is_router')
          has-error(:form='form', field='is_router')
</template>

<script>
  import Form from 'vform'

  export default {
    name: "Casual",

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