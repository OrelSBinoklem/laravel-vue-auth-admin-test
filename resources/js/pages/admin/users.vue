<template>
  <div class="row">
    <div class="col">
      <h1>Пользователи</h1>
      <div class="row justify-content-between mb-3">
        <div class="col-auto">
          <label for="users_filter" class="mt-2">Search for:</label>
        </div>
        <div class="col-auto pl-0">
          <div class="input-group">
            <input id="users_filter" type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="name or email">
            <div class="input-group-append" id="button-addon4">
              <button class="btn btn-outline-secondary" type="button" @click="doFilter">Go</button>
              <button class="btn btn-outline-secondary" type="button" @click="resetFilter">Reset</button>
            </div>
          </div>
        </div>
        <div class="col-auto">
          <label for="users_per_page" class="mt-2">Per Page:</label>
        </div>
        <div class="col-auto pl-0 mr-auto">
          <select id="users_per_page" class="form-control custom-select d-inline" v-model="perPage">
            <option :value="10">10</option>
            <option :value="25">25</option>
            <option :value="50">50</option>
            <option :value="100">100</option>
          </select>
        </div>
        <div class="col-auto">
          <b-button @click="onAddUser" size="lg" variant="success"><fa icon="user-plus" size="lg"/></b-button>
        </div>
      </div>
      <vuetable ref="vuetable"
                api-url="/api/admin/users/get-table"
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

      <div class="vuetable-footer justify-content-end d-flex">
        <!--<button class="btn btn-info footer-button" @click="onGroupAction()">Group action</button>-->

        <vuetable-pagination-info ref="paginationInfo"
        ></vuetable-pagination-info>

        <vuetable-pagination ref="pagination"
                             :css="paginationCss"
                             @vuetable-pagination:change-page="onChangePage"
        ></vuetable-pagination>
      </div>

      <b-modal id="modal-delete-user"
               ref="modal-delete-user"
               :title="'Точно удалить юзера &quot;' + (this.curEditUser ? this.curEditUser.name : '') + '&quot;?'"
               @ok="deleteUser">
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
      <b-modal id="modal-create-user"
               ref="modal-create-user"
               title="Добавить юзера"
               hide-footer>
        <form @submit.prevent="addUser" @keydown="addUserForm.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="addUserForm.name" :class="{ 'is-invalid': addUserForm.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="addUserForm" field="name"/>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="addUserForm.email" :class="{ 'is-invalid': addUserForm.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="addUserForm" field="email"/>
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="addUserForm.password" :class="{ 'is-invalid': addUserForm.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="addUserForm" field="password"/>
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input v-model="addUserForm.password_confirmation" :class="{ 'is-invalid': addUserForm.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="addUserForm" field="password_confirmation"/>
            </div>
          </div>

          <!-- Roles -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('roles_user') }}</label>
            <div class="col-md-7">
              <select v-model="addUserForm.roles_ids" size="4" multiple class="form-control custom-select">
                <option v-for="role in roles" v-bind:value="role.id">
                  {{ role.name }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="addUserForm.busy">
                Добавить юзера
              </v-button>
            </div>
          </div>
        </form>
        <template slot="modal-cancel">Нет</template>
        <template slot="modal-ok">Да</template>
      </b-modal>
      <b-modal id="modal-update-user"
               ref="modal-update-user"
               :title="'Обновить юзера &quot;' + (this.curEditUser ? this.curEditUser.name : '') + '&quot;?'"
               hide-footer>
        <form @submit.prevent="updateUser" @keydown="updateUserForm.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="updateUserForm.name" :class="{ 'is-invalid': updateUserForm.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="updateUserForm" field="name"/>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="updateUserForm.email" :class="{ 'is-invalid': updateUserForm.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="updateUserForm" field="email"/>
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="updateUserForm.password" :class="{ 'is-invalid': updateUserForm.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="updateUserForm" field="password"/>
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input v-model="updateUserForm.password_confirmation" :class="{ 'is-invalid': updateUserForm.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="updateUserForm" field="password_confirmation"/>
            </div>
          </div>

          <!-- Roles -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('roles_user') }}</label>
            <div class="col-md-7">
              <select v-model="updateUserForm.roles_ids" size="4" multiple class="form-control custom-select">
                <option v-for="role in roles" v-bind:value="role.id">
                  {{ role.name }}
                </option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="updateUserForm.busy">
                Обновить юзера
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

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('users') }
    },

    data: () => ({
      curEditUser: null,
      roles: [],
      filterText: '',
      perPage: 10,
      moreParams: {},

      addUserForm: new Form({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        roles_ids: []
      }),

      updateUserForm: new Form({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        roles_ids: []
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
          dataClass: 'text-right'
        },
        {
          name: '__checkbox',
          titleClass: 'text-center',
          dataClass: 'text-center'
        },
        {
          name: 'name',
          title: 'Full Name',
          titleClass: 'text-center',
          dataClass: 'text-left',
          sortField: 'name'
        },
        {
          name: 'roles',
          title: 'Роли',
          titleClass: 'text-center',
          dataClass: 'text-left',
          callback: 'rolesLabel',
          //sortField: 'roles'
        },
        {
          name: 'email',
          title: 'Email',
          titleClass: 'text-center',
          dataClass: 'text-left',
          sortField: 'email'
        },
        {
          name: 'email_verified_at',
          title: 'Verified',
          titleClass: 'text-center',
          dataClass: 'text-right',
          callback: 'verifiedLabel',
          sortField: 'email_verified_at'
        },
        {
          name: 'created_at',
          title: 'Created',
          titleClass: 'text-center',
          dataClass: 'text-right',
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
          field: 'name',
          sortField: 'name',
          direction: 'asc'
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
      // Column formatting
      rolesLabel (roles) {
        return roles.map(function callback(role) {
          return '<span class="badge badge-primary">' + (role.name) + '</span>'
        })
          .join(", ")
      },
      verifiedLabel (value) {
        return value === null
          ? '<span class="badge badge-warning">No</span>'
          : '<span class="badge badge-success">Verified</span>'
      },
      // Row button action handler
      async onAction (action, data, index) {
        if(action === 'delete-item') {
          this.curEditUser = data
          this.$root.$emit('bv::show::modal','modal-delete-user')
        }
        if(action === 'edit-item') {
          this.curEditUser = data
          this.updateUserForm.reset()
          this.updateUserForm.name = data.name
          this.updateUserForm.email = data.email
          this.updateUserForm.roles_ids = this.__getKeysRoles(data.roles)
          this.$root.$emit('bv::show::modal','modal-update-user')
          var res = await axios.get('/api/admin/roles')
          this.roles = res.data
        }
      },

      async onAddUser () {
        this.addUserForm.reset()
        this.$root.$emit('bv::show::modal','modal-create-user')
        var res = await axios.get('/api/admin/roles')
        this.roles = res.data
      },

      async deleteUser() {
        await axios.delete('/api/admin/users/' + this.curEditUser.id)
        this.$refs.vuetable.reload()
      },

      async addUser() {
        await this.addUserForm.post('/api/admin/users')
        this.$root.$emit('bv::hide::modal','modal-create-user')
        this.$refs.vuetable.reload()
      },

      async updateUser() {
        await this.updateUserForm.put('/api/admin/users/' + this.curEditUser.id)
        this.$root.$emit('bv::hide::modal','modal-update-user')
        this.$refs.vuetable.reload()
      },

      // Footer button action
      onGroupAction() {
        console.log('Group action. Selected rows: ', this.$refs.vuetable.selectedTo.join(', '));
      },

      doFilter () {
        this.moreParams = {
          filter: this.filterText
        }
        Vue.nextTick( () => this.$refs.vuetable.refresh())
      },
      resetFilter () {
        this.filterText = ''
        this.moreParams = {}
        Vue.nextTick( () => this.$refs.vuetable.refresh())
      },

      __getKeysRoles (roles) {
        return roles.map(function callback(role) {
          return role.id
        })
      }
    },

    watch: {
      perPage: function() {
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
  .vuetable th#_id {
    width: 50px;
  }
  .vuetable-th-checkbox-id {
    width: 50px;
  }
  /*.vuetable th#_name {
    width: 120px;
  }*/
  .vuetable th#_email {
    width: 200px;
  }
  .vuetable th#_email_verified_at {
    width: 80px;
  }
  .vuetable th#_created_at{
    width: 200px;
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