<template>
  <div class="row">
    <div class="col">
      <div class="row justify-content-between mb-3">
        <div class="col-auto ml-auto">
          <b-button @click="onAddRole" size="lg" variant="success"><fa icon="user-tie" size="lg"/>+</b-button>
        </div>
      </div>
      <div class="vuetable-roles">
        <vuetable ref="vuetable"
                  api-url="/api/admin/roles/get-table"
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

      <b-modal id="modal-delete-role"
               ref="modal-delete-role"
               :title="'Точно удалить роль &quot;' + (this.curEditRole ? this.curEditRole.name : '') + '&quot;?'"
               @ok="deleteRole">
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
      <b-modal id="modal-create-role"
               ref="modal-create-role"
               title="Добавить роль"
               hide-footer>
        <form @submit.prevent="addRole" @keydown="addRoleForm.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="addRoleForm.name" :class="{ 'is-invalid': addRoleForm.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="addRoleForm" field="name"/>
            </div>
          </div>

          <!-- Immunity -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('immunity') }}</label>
            <div class="col-md-7">
              <input v-model="addRoleForm.immunity" :class="{ 'is-invalid': addRoleForm.errors.has('immunity') }" class="form-control" type="text" name="immunity">
              <has-error :form="addRoleForm" field="immunity"/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button block :loading="addRoleForm.busy">
                Добавить роль
              </v-button>
            </div>
          </div>
        </form>
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
      <b-modal id="modal-update-role"
               ref="modal-update-role"
               :title="'Обновить роль &quot;' + (this.curEditRole ? this.curEditRole.name : '') + '&quot;?'"
               hide-footer>
        <form @submit.prevent="updateRole" @keydown="updateRoleForm.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="updateRoleForm.name" :class="{ 'is-invalid': updateRoleForm.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="updateRoleForm" field="name"/>
            </div>
          </div>

          <!-- Immunity -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('immunity') }}</label>
            <div class="col-md-7">
              <input v-model="updateRoleForm.immunity" :class="{ 'is-invalid': updateRoleForm.errors.has('immunity') }" class="form-control" type="text" name="immunity">
              <has-error :form="updateRoleForm" field="immunity"/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button block :loading="updateRoleForm.busy">
                Обновить роль
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
    name: "CrudTableRoles",
    data: () => ({
      curEditRole: null,
      perPage: 10,
      moreParams: {},

      addRoleForm: new Form({
        name: '',
        immunity: ''
      }),

      updateRoleForm: new Form({
        name: '',
        immunity: ''
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
          name: 'immunity',
          title: 'Immunity',
          titleClass: 'text-center',
          dataClass: 'text-right',
          sortField: 'immunity'
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
          this.curEditRole = data
          this.$root.$emit('bv::show::modal','modal-delete-role')
        }
        if(action === 'edit-item') {
          this.curEditRole = data
          this.updateRoleForm.reset()
          this.updateRoleForm.name = data.name
          this.updateRoleForm.immunity = data.immunity
          this.$root.$emit('bv::show::modal','modal-update-role')
          var res = await axios.get('/api/admin/roles')
          this.roles = res.data
        }
      },

      async onAddRole () {
        this.addRoleForm.reset()
        this.$root.$emit('bv::show::modal','modal-create-role')
      },

      async deleteRole() {
        await axios.delete('/api/admin/roles/' + this.curEditRole.id)
        this.$refs.vuetable.reload()
      },

      async addRole() {
        await this.addRoleForm.post('/api/admin/roles')
        this.$root.$emit('bv::hide::modal','modal-create-role')
        this.$refs.vuetable.reload()
      },

      async updateRole() {
        await this.updateRoleForm.put('/api/admin/roles/' + this.curEditRole.id)
        this.$root.$emit('bv::hide::modal','modal-update-role')
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
  .vuetable-roles th,
  .vuetable-roles td {
    padding: 0.375rem;
  }
  .vuetable th#_id {
    width: 50px;
  }
  /*.vuetable th#_name {
    width: 120px;
  }*/
  .vuetable th#_immunity {
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