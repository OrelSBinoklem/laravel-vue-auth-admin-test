<template lang="pug">
  .row
    .col-6
      // Material
      .form-group.row
        //todo-orel перевести
        label.col-12 Материал
        .col-12
          input.form-control(v-model='form.editors[index].slug', :class="{ 'is-invalid': form.errors.has(`editors.${index}.slug`) }", type='text', :name="'editor-slug' + index")
          has-error(:form='form', :field='`editors.${index}.slug`')
        .col-12
          editor(v-model='form.editors[index].text', @init='editorInit', lang='html', theme='chrome', width='100%', :height='150')
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`editors.${index}.text`) }")
          has-error(:form='form', :field='`editors.${index}.text`')
    SelectMaterial(:content_type="form.content_type" :open.sync="openSelectMaterial" @select="onSelectMaterial")
</template>

<script>

  export default {
    name: "Admin",

    components: {

    },

    props: {

    },

    data: () => ({

    }),

    computed: {

    },

    methods: {
      //todo-orel-cur Зделать чтоб в зависимости от количества строк высота редактора становилась больше
    },

    watch: {

    }
  }
</script>

<style>

</style>