<template lang="pug">
  .col-12
    // Material
    .form-group.row
      .col-12
        b-form-select(v-model='data.props.variant', :options='variantOptions')
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.variant`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.variant`')
      .col-12.mt-3
        b-form-input(v-model='data.props.heading' placeholder="Заголовок (необязательно)")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.heading`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.heading`')
      .col-12.mt-3
        editor(v-model='data.props.html', @init='editorInit', lang='html', theme='chrome', width='100%', :height='150')
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.html`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.html`')
</template>

<script>
  import Vue from 'vue'
  import {mixinAdmin} from '../mixinAdmin'

  export default {
    name: "Admin",

    mixins: [mixinAdmin],

    components: {
      editor: require('vue2-ace-editor')
    },

    props: {

    },

    beforeMount() {
      if(!('props' in this.data)) {
        Vue.set(this.data, 'props', {});
        Vue.set(this.data.props, 'variant', 'info');
        Vue.set(this.data.props, 'heading', '');
        Vue.set(this.data.props, 'html', '');
      } else {
        if(!('variant' in this.data.props)) {
          this.data.props.variant = 'info'
        }
        if(!('heading' in this.data.props) || this.data.props.heading === null) {
          this.data.props.heading = ''
        }
        if(!('html' in this.data.props) || this.data.props.html === null) {
          this.data.props.html = ''
        }
      }
    },

    data: () => ({
      variantOptions: [
        { value: null, text: 'Выберите тип' },
        { value: 'danger', text: 'Danger' },
        { value: 'warning', text: 'Warning' },
        { value: 'info', text: 'Info' }
      ],

      staticRules: {
        /*slot: {
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
        }*/
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