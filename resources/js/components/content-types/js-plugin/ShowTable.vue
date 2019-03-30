<template>
  <div class="row">
    <div class="col">
      <h1>{{$t('js-plugin')}}</h1>
      <div class="row justify-content-between mb-3">
        <div class="col-auto ml-auto">
          <b-button @click="onAddContent" size="lg" variant="success"><fa icon="user-tie" size="lg"/>+</b-button>
        </div>
      </div>
      <div class="vuetable-js-plugin">
        <vuetable ref="vuetable"
                  api-url="/api/admin/content/js-plugin/get-table"
                  pagination-path=""
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
                  :per-page="perPage"
                  @vuetable:pagination-data="onPaginationData"
                  :append-params="moreParams"
        >
          <template slot="actions" slot-scope="props">
            <div class="custom-actions">
              <button class="btn btn-default btn-sm"
                      @click="onAction('edit-item', props.rowData, props.rowIndex)">
                <span class="glyphicon glyphicon-pencil"></span>
              </button>
              <button class="btn btn-danger btn-sm"
                      @click="onAction('delete-item', props.rowData, props.rowIndex)">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </template>

        </vuetable>
      </div>

      <div class="vuetable-footer justify-content-end d-flex">
        <vuetable-pagination-info ref="paginationInfo"
        ></vuetable-pagination-info>

        <vuetable-pagination ref="pagination"
                             :css="paginationCss"
                             @vuetable-pagination:change-page="onChangePage"
        ></vuetable-pagination>
      </div>

      <b-modal id="modal-delete-plugin"
               ref="modal-delete-plugin"
               :title="'Точно удалить плагин &quot;' + (this.curEditPlugin ? this.curEditPlugin.title : '') + '&quot;?'"
               @ok="deletePlugin">
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import Form from 'vform'
  import axios from 'axios'
  import moment from 'moment'

  import {mixinShow} from '../mixinShow'

  export default {
    name: "CrudTableRoles",

    mixins: [mixinShow],

    data: () => ({
      curEditPlugin: null,
      perPage: 10,
      moreParams: {},

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
          sortField: 'immunity'
        },
        {
          name: 'published',
          title: 'Опуб.',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'publishedLabel',
          sortField: 'published'
        },
        {
          name: 'viewed',
          title: 'Просмотры',
          titleClass: 'text-center',
          dataClass: 'text-right',
          sortField: 'viewed'
        },
        {
          name: 'created_at',
          title: 'Created',
          titleClass: 'text-center',
          dataClass: 'text-right',
          callback: 'createdAtLabel',
          sortField: 'created_at'
        },
        {
          name: '__slot:actions',
          title: 'Actions',
          titleClass: 'text-center',
          dataClass: 'text-center'
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
      // Column formatting
      createdAtLabel (value) {
        return moment(value).format("DD-MM-YYYY HH:mm")
      },
      // Row button action handler
      async onAction (action, data, index) {
        if(action === 'edit-item') {
          this.$router.push({ name: 'admin.content.update', params: { type: this.type.slug, id: data.id } })
        }

        if(action === 'delete-item') {
          this.curEditPlugin = data
          this.$root.$emit('bv::show::modal','modal-delete-plugin')
        }
      }
    },

    watch: {
      perPage: function() {
        Vue.nextTick( () => this.$refs.vuetable.refresh())
      },
      language: function() {
        Vue.nextTick( () => this.$refs.vuetable.refresh())
      }
    }
  }
</script>

<style>
  /**
   * Disabling multi-line text
   */
  .vuetable-body > tr > td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  /*
   * Column width
   */
  table.vuetable {
    width: 100%;
    table-layout: fixed;
  }
  .vuetable-js-plugin th,
  .vuetable-js-plugin td {
    padding: 0.375rem;
  }
  .vuetable th#_id {
    width: 50px;
  }
  /*.vuetable th#_name {
    width: 120px;
  }*/
  .vuetable th#_published {
    width: 80px;
  }
  .vuetable th#_created_at{
    width: 150px;
  }
  .vuetable .vuetable-th-slot-actions {
    width: 100px;
  }
  /**
   * Footer
   */
  .vuetable-footer {
    height: 40px;
    margin: 0 0 20px 0;
  }
  .vuetable-pagination-info, .footer-button {
    float: left;
  }
  .vuetable-pagination-info {
    padding: 12px 25px;
    line-height: 14px;
  }
  .pagination {
    float: right;
    margin: 0;
  }
  .vuetable-footer:after{
    clear: both;
  }
</style>