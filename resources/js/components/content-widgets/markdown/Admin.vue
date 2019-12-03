<template lang="pug">
  .col-12
    // Material
    .form-group.row
      .col-12.mt-3
        //todo попробовать заменить классы на fas https://github.com/nasa8x/v-markdown-editor/issues/3
        markdown-editor(:options="options" v-model="data.props.code" :buttons="buttons")
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

    },

    props: {

    },

    beforeMount() {
      //todo-orel Зделать функцию задания параметров по умолчанию - чтоб всё это сократить
      if(!('props' in this.data)) {
        Vue.set(this.data, 'props', {});
        Vue.set(this.data.props, 'code', '');
      } else {
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

      options: {
        // lineNumbers: true,
        // styleActiveLine: true,
        // styleSelectedText: true,
        // lineWrapping: true,
        // indentWithTabs: true,
        // tabSize: 2,
        // indentUnit: 2
      },

      buttons:  {

        'bold': {
          title: 'Bold',
          className: 'fas fa-bold',
          cmd: 'bold',
          hotkey: 'Ctrl-B'
        },

        'italic': {
          title: 'Italic',
          className: "fas fa-italic",
          cmd: 'italic',
          hotkey: 'Ctrl-I'
        },

        "strikethrough": {
          cmd: "strikethrough",
          className: "fas fa-strikethrough",
          title: "Strikethrough"
        },

        'heading': {
          title: 'Heading',
          className: "fas fa-heading",
          cmd: 'heading',
          hotkey: 'Ctrl-H'
        },

        'code': {
          title: 'Code',
          className: "fas fa-code",
          cmd: 'code',
          hotkey: 'Ctrl-X'
        },
        'quote': {
          title: 'Quote',
          className: "fas fa-quote-left",
          cmd: 'quote',
          hotkey: 'Ctrl-Q'
        },
        'link': {
          title: 'Link',
          className: "fas fa-link",
          cmd: 'link',
          hotkey: 'Ctrl-K'
        },
        'image': {
          title: 'Image',
          className: "fas fa-image",
          cmd: 'image',
          hotkey: 'Ctrl-P'
        },
        "fullscreen": {
          cmd: "fullscreen",
          className: "fas fa-arrows-alt no-disable no-mobile",
          title: "Toggle Fullscreen",
          hotkey: 'F11',
          ready: true
        },
        "preview": {
          cmd: "preview",
          className: "fas fa-eye no-disable",
          title: "Toggle Preview",
          hotkey: 'Ctrl-P',
          ready: true
        },

        "clipboard": {
          cmd: "clipboard",
          className: "fas fa-clipboard",
          title: "Copy & Markdown Format",
          hotkey: 'Ctrl-V'
        },

        "clean": {
          cmd: "clean",
          className: "fas fa-remove-format",
          title: "Clean html format"
        },

        "undo": {
          cmd: "undo",
          className: "fas fa-undo",
          title: "Undo",
          hotkey: 'Ctrl-Z'
        },

        "redo": {
          cmd: "redo",
          className: "fas fa-redo",
          title: "Redo",
          hotkey: 'Ctrl-Y'
        },

        "bullist": {
          cmd: "bullist",
          className: "fas fa-list-ul",
          title: "Generic List",

        },
        "numlist": {
          cmd: "numlist",
          className: "fas fa-list-ol",
          title: "Numbered List"
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

    },

    watch: {

    }
  }
</script>

<style>

</style>