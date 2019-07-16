import { mapGetters } from 'vuex'
import axios from 'axios'

export const mixinClient = {
  metaInfo () {
    return {

    }
  },

  props: {

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

      require('brace/mode/text')

      require('brace/mode/jade')
      require('brace/mode/html')
      require('brace/mode/xml')
      require('brace/mode/svg')
      require('brace/mode/css')
      require('brace/mode/sass')
      require('brace/mode/scss')
      require('brace/mode/less')
      require('brace/mode/stylus')
      require('brace/mode/javascript')    //language
      require('brace/mode/typescript')    //language
      require('brace/mode/coffee')
      require('brace/mode/json')
      require('brace/mode/yaml')
      require('brace/mode/php')

      require('brace/mode/sql')
      require('brace/mode/mysql')
      require('brace/mode/pgsql')

      require('brace/theme/chrome')
      require('brace/snippets/javascript') //snippet
    }
  },
  computed: {

  },
  watch: {

  },
}