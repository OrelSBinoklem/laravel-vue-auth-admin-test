import $ from 'jquery'
import _ from 'lodash'
import { mapGetters } from 'vuex'
import axios from "axios/index";

export const mixinCreateAndEdit = {
  components: {
    editor: require('vue2-ace-editor')
  },

  props: {

  },

  beforeMount() {
    document.body.addEventListener('click', this.onClickOutsidePosition)
  },

  beforeDestroy() {
    document.body.removeEventListener('click', this.onClickOutsidePosition)
  },

  data() {
    return {
      categories: [],
      tags: [],
      css: {
        tableClass: 'table table-striped table-bordered',
        loadingClass: 'loading',
        ascendingIcon: 'glyphicon glyphicon-chevron-up',
        descendingIcon: 'glyphicon glyphicon-chevron-down',
        handleIcon: 'glyphicon glyphicon-menu-hamburger',
        pagination: {
          infoClass: 'pull-left',
          wrapperClass: 'vuetable-pagination pull-right',
          activeClass: 'btn-primary',
          disabledClass: 'disabled',
          pageClass: 'btn btn-border',
          linkClass: 'btn btn-border',
          icons: {
            first: '',
            prev: '',
            next: '',
            last: '',
          },
        },
      },

      paginationCss: {
        wrapperClass: 'pagination',
        activeClass: 'btn-primary',
        disabledClass: 'disabled',
        pageClass: 'btn btn-border',
        linkClass: 'btn btn-border',
        icons: {
          first: '',
          prev: '',
          next: '',
          last: '',
        }
      },
    }
  },
  created() {

  },
  methods: {
    __arrJoinQuotes (arr) {
      return arr.map(function callback(tax) {
        return '<span class="badge badge-primary">' + (tax.title) + '</span>'
      })
        .join(", ")
    },

    __getIdsFromArr (arr) {
      return arr.map(function callback(el) {
        return el.id
      })
    },

    __findByIds (collection, ids) {
      var result = []

      //для оптимизации id превращаем в ключи объекта
      var idsO = {}
      ids.reduce((idsO, val) => {idsO[val] = true; return idsO}, idsO)
      //\

      for(var val of collection) {
        if(val.id in idsO) {
          result.push(val)
        }
      }

      return result
    },

    __reloadCategories() {
      axios
        .get('/api/admin/categories')
        .then(response => {
          this.categories = this.__setTreeIndent(response.data)
        }).catch(err => (console.log(err)))
    },

    __reloadTags() {
      axios
        .get('/api/admin/tags')
        .then(response => {
          this.tags = response.data
        }).catch(err => (console.log(err)))
    },

    __setTreeIndent(arr) {
      var r = []
      //отсортированные по дереву вложенности - вначали превращаем в дерево потом вживляем отступ а потом делаем плоским но порядок от дерева сохраняеться...
      var sortedAndIndentFlat = []
      arr.forEach(function (a) {
        if(this[a.id]) {
          this[a.id] = {...this[a.id], ...a}
        } else {
          this[a.id] = {...a}
        }

        if (a.parent_id === null) {
          r.push(this[a.id])
        } else {
          this[a.parent_id] = this[a.parent_id] || {}
          this[a.parent_id].children = this[a.parent_id].children || []
          this[a.parent_id].children.push(this[a.id])
        }
      }, Object.create(null))

      recursion(r, 0)

      function recursion(arr, indent) {
        for(let el of arr) {
          sortedAndIndentFlat.push(el)
          el.indent = indent
          if('children' in el && el.children.length) {
            recursion(el.children, indent + 1)
          }
        }
      }

      return sortedAndIndentFlat;
    },

    editorInit: function () {
      require('brace/ext/language_tools') //language extension prerequsite...
      require('brace/mode/html')
      require('brace/mode/javascript')    //language
      require('brace/mode/css')
      require('brace/mode/less')
      require('brace/theme/chrome')
      require('brace/snippets/javascript') //snippet
    },

    onClickOutsidePosition(e) {
      if (!($(e.target).closest('.position, .sidebar-menu-widgets').length)) {
        this.$store.dispatch('content-widgets/setSelectPosition', null)
      }
    }
  },
  computed: {
    ...mapGetters({
      language: 'lang/locale'
    })
  },
  watch: {

  },
}