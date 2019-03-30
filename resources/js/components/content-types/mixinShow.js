import { mapGetters } from 'vuex'
import axios from 'axios'

export const mixinShow = {
  props: {
    type: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
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
    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    publishedLabel (value) {
      return value == 0
        ? '<span class="badge badge-secondary">No</span>'
        : '<span class="badge badge-success">Yes</span>'
    },
    onAddContent () {
      this.$router.push({ name: 'admin.content.create', params: { type: this.type.slug } })
    },
    async deletePlugin() {
      await axios.delete('/api/admin/content/' + this.type.slug + '/' + this.curEditPlugin.id)
      this.$refs.vuetable.reload()
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