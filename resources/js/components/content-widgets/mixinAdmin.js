export const mixinAdmin = {
  props: {
    edit: {
      type: Boolean,
      required: true
    },

    data: {
      type: Object,
      required: true
    },
  },

  data() {
    return {

    }
  },
  created() {

  },
  methods: {
    editorInit: function () {
      require('brace/ext/language_tools') //language extension prerequsite...
      require('brace/mode/html')
      require('brace/mode/javascript')    //language
      require('brace/mode/css')
      require('brace/mode/less')
      require('brace/theme/chrome')
      require('brace/snippets/javascript') //snippet
    }
  },
  computed: {

  },
  watch: {

  },
}