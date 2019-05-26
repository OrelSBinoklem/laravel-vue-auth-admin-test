<template lang="pug">
  .row
    .col-6
      // Material
      .form-group.row
        //todo-orel перевести
        label.col-12 Алерт
        .col-12
          b-form-select(v-model='data.props.variant', :options='typesOptions')
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.variant`) }")
          has-error(:form='form', :field='`${prefixDataForm}.props.variant`')
        .col-12
          editor(v-model='data.text', @init='editorInit', lang='html', theme='chrome', width='100%', :height='150')
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.text`) }")
          has-error(:form='form', :field='`${prefixDataForm}.text`')
</template>

<script>

  export default {
    name: "Admin",

    components: {

    },

    props: {

    },

    beforeMount() {

    },

    data: () => ({
      variantOptions: [
        { value: null, text: 'Выберите тип' },
        { value: 'primary', text: 'Primary' },
        { value: 'secondary', text: 'Secondary' },
        { value: 'success', text: 'Success' },
        { value: 'danger', text: 'Danger' },
        { value: 'warning', text: 'Warning' },
        { value: 'info', text: 'Info' },
        { value: 'light', text: 'Light' },
        { value: 'dark', text: 'Dark' }
      ],

      staticRules: {
        slot: {
          rules: [
            {
              name: /^alert2$/gmi,
              count: '*',
              not: {
                props: [
                  {'variant': /^light|dark/gim}
                ]
              }
            },
            {
              name: /^button$/gim
            }
          ],
          widgets: []
        }
      }
    }),

    computed: {
      positions() {
        //Чтоб постоянно несоздавался объект
        return this.staticRules
      }
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