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
        if(key in this.staticRules) {
          this.data.positions[key] = {rules: this.staticRules[key], widgets: []}
        }
      }
    } else {
      for(let key in this.positions) {
        if(!(key in this.data.positions)){
          this.data.positions[key] = {}
        }
        this.data.positions[key].rules = this.staticRules[key]
        if(!('widgets' in this.data.positions[key])){
          this.data.positions[key].widgets = []
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