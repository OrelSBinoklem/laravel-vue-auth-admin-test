<template lang="pug">
  .col-12
    .form-group.row
      .col-12
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
        Vue.set(this.data.props, 'html', '');
      } else {
        if(!('html' in this.data.props) || this.data.props.html === null) {
          this.data.props.html = ''
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