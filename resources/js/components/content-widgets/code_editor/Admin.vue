<template lang="pug">
  .col-12
    // Material
    .form-group.row
      .col-12
        b-form-select(v-model='data.props.variant', :options='variantOptions')
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.variant`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.variant`')
      .col-6.mt-3
        b-form-input(v-model='data.props.min_lines' placeholder="мин. строк")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.min_lines`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.min_lines`')
      .col-6.mt-3
        b-form-input(v-model='data.props.max_lines' placeholder="макс. строк")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.max_lines`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.max_lines`')
      .col-12.mt-3
        editor(v-model='data.props.code', @init='editorInit', lang='data.props.variant', theme='chrome', width='100%', :height='150')
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.code`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.code`')
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
      //todo-orel Зделать функцию задания параметров по умолчанию - чтоб всё это сократить
      if(!('props' in this.data)) {
        Vue.set(this.data, 'props', {});
        Vue.set(this.data.props, 'variant', null);
        Vue.set(this.data.props, 'min_lines', 5);
        Vue.set(this.data.props, 'max_lines', 10);
        Vue.set(this.data.props, 'code', '');
      } else {
        if(!('variant' in this.data.props)) {
          this.data.props.variant = null
        }
        if(!('min_lines' in this.data.props)) {
          this.data.props.min_lines = 5
        }
        if(!('max_lines' in this.data.props)) {
          this.data.props.max_lines = 10
        }
        if(!('code' in this.data.props)) {
          this.data.props.code = ''
        }
      }
    },

    data: () => ({
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
      },

      variantOptions: [
        { value: null, text: 'Выберите язык' },

        { value: 'jade', text: 'jade' },
        { value: 'html', text: 'html' },

        { value: 'svg', text: 'svg' },

        { value: 'css', text: 'css' },
        { value: 'sass', text: 'sass' },
        { value: 'scss', text: 'scss' },
        { value: 'less', text: 'less' },
        { value: 'stylus', text: 'stylus' },

        { value: 'javascript', text: 'javascript' },
        { value: 'typescript', text: 'typescript' },
        { value: 'coffee', text: 'coffee' },

        { value: 'json', text: 'json' },
        { value: 'yaml', text: 'yaml' },
        { value: 'xml', text: 'xml' },

        { value: 'php', text: 'php' }
      ]
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