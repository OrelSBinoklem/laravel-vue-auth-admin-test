<template lang="pug">
  div
    //todo-orel перевод
    b-modal#modal-select-material(:visible="open" @change="onChange" ref='modal-select-material' size="lg" title='Выберите материал')
      .vuetable-select-material(v-if="content_type !== null && open")
        vuetable(ref="vuetable"
        :api-url='"/api/admin/content/" + content_type + "/get-table"'
        pagination-path=''
        :fields='fields'
        :css='css'
        :sort-order='sortOrder'
        :per-page='perPage'
        @vuetable:pagination-data='onPaginationData'
        @vuetable:row-clicked="onRowClicked"
        :append-params='moreParams')
        .vuetable-footer.justify-content-end.d-flex
          vuetable-pagination-info(ref='paginationInfo')
          vuetable-pagination(ref='pagination', :css='paginationCss', @vuetable-pagination:change-page='onChangePage')
        //todo-orel перевести
      template(slot='modal-footer')
        b-button(variant='secondary') Отмена
</template>

<script>
  import Form from 'vform'
  import moment from 'moment'

  export default {
    name: "SelectMaterial",

    props: {
      open: {
        type: Boolean,
        required: true
      },
      content_type: {
        validator: function (value) {
          return value === null || typeof value == 'string'
        },
        required: true
      }
    },

    data: () => ({
      perPage: 10,
      moreParams: {},

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

      fields: [
        {
          name: 'id',
          title: '#',
          titleClass: 'text-center',
          dataClass: 'text-right',
          sortField: 'id'
        },
        {
          name: 'title',
          title: 'Title',
          titleClass: 'text-center',
          dataClass: 'text-left',
          sortField: 'title'
        },
        {
          name: 'slug',
          title: 'Slug',
          titleClass: 'text-center',
          dataClass: 'text-right',
          sortField: 'slug'
        },
        {
          name: 'created_at',
          title: 'Created',
          titleClass: 'text-center',
          dataClass: 'text-right',
          callback: function (value) {
            return moment(value).format("DD-MM-YYYY HH:mm")
          },
          sortField: 'created_at'
        }
      ],
      sortOrder: [
        {
          field: 'created_at',
          sortField: 'created_at',
          direction: 'desc'
        }
      ]
    }),

    computed: {

    },

    methods: {
      onPaginationData (paginationData) {
        this.$refs.pagination.setPaginationData(paginationData)
        this.$refs.paginationInfo.setPaginationData(paginationData)
      },

      onChangePage (page) {
        this.$refs.vuetable.changePage(page)
      },

      onChange (e) {
        this.$emit('update:open', e)
      },

      onRowClicked(row){
        this.$emit('update:open', false)
        this.$emit('select', row)
      }
    },

    watch: {

    }
  }
</script>

<style>
  .vuetable-select-material td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .vuetable-select-material th#_id {
    width: 50px;
  }

  .vuetable-select-material th#_created_at{
    width: 150px;
  }

  .vuetable-select-material th,
  .vuetable-select-material td {
    padding: 0.375rem;
  }
</style>