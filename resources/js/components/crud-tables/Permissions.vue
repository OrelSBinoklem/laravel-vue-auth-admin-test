<template>
  <div class="row">
    <div class="col">
      <div class="row justify-content-between mb-3">
        <div class="col-auto ml-auto">
          <b-button @click="onAddPermission" size="lg" variant="success"><fa icon="file-contract" size="lg"/>+</b-button>
        </div>
      </div>
      <div class="vuetable-permissions">
        <vuetable ref="vuetable"
                  api-url="/api/admin/permissions/get-table"
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

      <b-modal id="modal-delete-permission"
               ref="modal-delete-permission"
               :title="'Точно удалить право &quot;' + (this.curEditPermission ? this.curEditPermission.name : '') + '&quot;?'"
               @ok="deletePermission">
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
      <b-modal id="modal-create-permission"
               ref="modal-create-permission"
               title="Добавить право"
               hide-footer>
        <form @submit.prevent="addPermission" @keydown="addPermissionForm.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="addPermissionForm.name" :class="{ 'is-invalid': addPermissionForm.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="addPermissionForm" field="name"/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button block :loading="addPermissionForm.busy">
                Добавить право
              </v-button>
            </div>
          </div>
        </form>
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
      <b-modal id="modal-update-permission"
               ref="modal-update-permission"
               :title="'Обновить право &quot;' + (this.curEditPermission ? this.curEditPermission.name : '') + '&quot;?'"
               hide-footer>
        <form @submit.prevent="updatePermission" @keydown="updatePermissionForm.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="updatePermissionForm.name" :class="{ 'is-invalid': updatePermissionForm.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="updatePermissionForm" field="name"/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button block :loading="updatePermissionForm.busy">
                Обновить право
              </v-button>
            </div>
          </div>
        </form>
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
  import { mapGetters } from 'vuex'

  export default {
    name: "CrudTablePermissions",
    data: () => ({
      curEditPermission: null,
      perPage: 10,
      moreParams: {},

      addPermissionForm: new Form({
        name: ''
      }),

      updatePermissionForm: new Form({
        name: ''
      }),

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
          name: 'name',
          title: 'Full Name',
          titleClass: 'text-center',
          dataClass: 'text-left',
          sortField: 'name'
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
          field: 'id',
          sortField: 'id',
          direction: 'asc'
        }
      ]
    }),

    computed: {
      ...mapGetters({
        language: 'lang/locale'
      })
    },

    methods: {
      onPaginationData (paginationData) {
        this.$refs.pagination.setPaginationData(paginationData)
        this.$refs.paginationInfo.setPaginationData(paginationData)
      },
      onChangePage (page) {
        this.$refs.vuetable.changePage(page)
      },
      // Column formatting
      createdAtLabel (value) {
        return moment(value).format("DD-MM-YYYY HH:mm")
      },
      // Row button action handler
      async onAction (action, data, index) {
        if(action === 'delete-item') {
          this.curEditPermission = data
          this.$root.$emit('bv::show::modal','modal-delete-permission')
        }
        if(action === 'edit-item') {
          this.curEditPermission = data
          this.updatePermissionForm.reset()
          this.updatePermissionForm.name = data.name
          this.$root.$emit('bv::show::modal','modal-update-permission')
          var res = await axios.get('/api/admin/permissions')
          this.permissions = res.data
        }
      },

      async onAddPermission () {
        this.addPermissionForm.reset()
        this.$root.$emit('bv::show::modal','modal-create-permission')
      },

      async deletePermission() {
        await axios.delete('/api/admin/permissions/' + this.curEditPermission.id)
        this.$refs.vuetable.reload()
      },

      async addPermission() {
        await this.addPermissionForm.post('/api/admin/permissions')
        this.$root.$emit('bv::hide::modal','modal-create-permission')
        this.$refs.vuetable.reload()
      },

      async updatePermission() {
        await this.updatePermissionForm.put('/api/admin/permissions/' + this.curEditPermission.id)
        this.$root.$emit('bv::hide::modal','modal-update-permission')
        this.$refs.vuetable.reload()
      },
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
  .vuetable-permissions th,
  .vuetable-permissions td {
    padding: 0.375rem;
  }
  .vuetable th#_id {
    width: 50px;
  }
  /*.vuetable th#_name {
    width: 120px;
  }*/
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