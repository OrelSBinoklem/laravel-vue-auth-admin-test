import Form from 'vform'

export const mixinAdmin = {
  props: {
    edit: {
      type: Boolean,
      required: true
    },

    form: {
      type: Form,
      required: true
    },

    data: {
      type: Object,
      required: true
    },

    prefixDataForm: {
      type: String,
      required: true
    }
  },

  beforeMount() {
    if(!('positions' in this.data)) {this.data.positions = {}}

    if(!this.edit) {
      for(let key in this.positions) {
          this.data.positions[key] = {
            rules: this.positions[key].rules,
            widgets: 'widgets' in this.positions[key] ? this.positions[key].widgets : []
          }
      }
    } else {
      for(let key in this.positions) {
        if(!(key in this.data.positions)){
          this.data.positions[key] = {}
        }
        this.data.positions[key].rules = this.positions[key].rules
        if(!('widgets' in this.data.positions[key])){
          this.data.positions[key].widgets = 'widgets' in this.positions[key] ? this.positions[key].widgets : []
        }
      }
    }
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