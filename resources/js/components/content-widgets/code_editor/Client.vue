<template lang="pug">
  editor(ref="editor" @init='editorInit' :value='code', :lang='variant', theme='chrome', width='100%', :height='height')
</template>

<script>
  import {mixinClient} from '../mixinClient'

  export default {
    name: "Client",

    mixins: [mixinClient],

    components: {
      editor: require('vue2-ace-editor')
    },

    props: {
      variant: {
        type: String,
        required: true
      },

      min_lines: {
        required: true
      },

      max_lines: {
        required: true
      },

      code: {
        type: String,
        required: true
      }
    },

    data: () => ({
      //todo-orel Добавить изменение размера шрифта
      fontSize: 12,
      lineHeight: 14
    }),

    mounted () {
      //this.$refs.editor.editor.setFontSize(this.fontSize + "px");
      this.$refs.editor.editor.setReadOnly(true);
    },

    computed: {
      height() {
        let lines = this.countLine(this.code) + 1

        if(lines < parseInt(this.min_lines)) {
          lines = parseInt(this.min_lines)
        }

        if(lines > parseInt(this.max_lines)) {
          lines = parseInt(this.max_lines)
        }

        return (lines * this.lineHeight) + 1
      }
    },

    methods: {
      countLine(text) {
        let lines = text.split("\n");
        let count = 0;
        for (let i = 0; i < lines.length - 1; i++) {
          if (lines[i].trim() != "" && lines[i].trim() !== null) {
            count++;
          }
        }
        return count;
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>