<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>{{$t('users')}}</h1>
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
                  pagination-path="pagination"
                  :fields="fields"
                  :css="css"
                  :sort-order="sortOrder"
                  :per-page="perPage"
                  data-path="mydata"
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
  <!--        <b-dropdown id="ddown1" text="Бан" class="m-md-2">
            <b-dropdown-item @click="onGroupBan()">5 мин</b-dropdown-item>
            <b-dropdown-item @click="onGroupBan()">15 мин</b-dropdown-item>
            <b-dropdown-item @click="onGroupBan()">День</b-dropdown-item>
            <b-dropdown-item @click="onGroupBan()">Неделя</b-dropdown-item>
            <b-dropdown-item @click="onGroupBan()">Перманент</b-dropdown-item>
          </b-dropdown>-->
          <b-button-group>
            <button class="btn btn-info footer-button" @click="onGroupBan()">Group bans</button>
            <button class="btn btn-info footer-button" @click="onGroupDelete()">Group delete</button>
          </b-button-group>

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
                <v-button block :loading="addUserForm.busy">
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

            <!-- Ban -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('ban_user') }}</label>
              <div class="col-md-7">
                <div class="input-group">
                  <vue-ctk-date-time-picker
                          v-if="typeof updateUserForm.bans_expired_at != 'boolean'"
                          v-model="updateUserForm.bans_expired_at"
                          :minute-interval="5"
                          :min-date="__getCurDateTimeMoment().format('YYYY-MM-DD')"
                          format="DD-MM-YYYY HH:mmZ"
                          formatted="DD-MM-YYYY HH:mmZ"
                          time-format='HH:mm'
                          :error-hint="updateUserForm.errors.has('bans_expired_at')"
                          :locale="language"
                  ></vue-ctk-date-time-picker>
                </div>
                <div class="btn-group btn-group-justified mt-1">
                    <button class="btn btn-outline-primary" :class="{active: updateUserForm.bans_expired_at === false}" type="button" @click="updateUserForm.bans_expired_at = false">Нету</button>
                    <button class="btn btn-outline-primary" :class="{active: typeof updateUserForm.bans_expired_at != 'boolean'}" type="button" @click="updateUserForm.bans_expired_at = __getCurDateTime()"><fa icon="calendar-alt"/></button>
                    <button class="btn btn-outline-primary" :class="{active: updateUserForm.bans_expired_at === true}" type="button" @click="updateUserForm.bans_expired_at = true">Перманент</button>
                </div>
                <div class="form-control is-invalid d-none"></div>
                <has-error :form="updateUserForm" field="bans_expired_at"/>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button block :loading="updateUserForm.busy">
                  Обновить юзера
                </v-button>
              </div>
            </div>
          </form>
          <template slot="modal-cancel">Нет</template>
          <template slot="modal-ok">Да</template>
        </b-modal>
        <b-modal id="modal-ban-group-users"
                 ref="modal-ban-group-users"
                 title="Забанить юзеров"
                 @ok="groupBan">
          <!-- Ban -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('ban_user') }}</label>
            <div class="col-md-7">
              <div class="input-group">
                <!--но надо и по времени минимум(((-->
                <vue-ctk-date-time-picker
                        v-if="typeof dateTimeBanUsers != 'boolean'"
                        v-model="dateTimeBanUsers"
                        :minute-interval="5"
                        :min-date="__getCurDateTimeMoment().format('YYYY-MM-DD')"
                        format="DD-MM-YYYY HH:mmZ"
                        formatted="DD-MM-YYYY HH:mmZ"
                        time-format='HH:mm'
                        :error-hint="!__timeIsFuture(dateTimeBanUsers)"
                        :locale="language"
                ></vue-ctk-date-time-picker>
                <div class="btn-group btn-group-justified mt-1">
                  <button class="btn btn-outline-primary" :class="{active: dateTimeBanUsers === false}" type="button" @click="dateTimeBanUsers = false">Нету</button>
                  <button class="btn btn-outline-primary" :class="{active: typeof dateTimeBanUsers != 'boolean'}" type="button" @click="dateTimeBanUsers = __getCurDateTime()"><fa icon="calendar-alt"/></button>
                  <button class="btn btn-outline-primary" :class="{active: dateTimeBanUsers === true}" type="button" @click="dateTimeBanUsers = true">Перманент</button>
                </div>
              </div>
            </div>
          </div>
          <template slot="modal-cancel">Отмена</template>
          <template slot="modal-ok">Применить</template>
        </b-modal>
        <b-modal id="modal-delete-group-users"
                 ref="modal-delete-group-users"
                 title="Точно удалить юзеров?"
                 @ok="groupDelete">
          <template slot="modal-cancel">Нет</template>
          <template slot="modal-ok">Да</template>
        </b-modal>
      </div>
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
        roles_ids: [],
        bans_expired_at: false
      }),

      dateTimeBanUsers: null,

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
          name: 'ban_duration',
          title: 'Banned',
          titleClass: 'text-center',
          dataClass: 'text-right',
          callback: 'bannedLabel',
          //sortField: 'email_verified_at'
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
          field: 'name',
          sortField: 'name',
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
      transform: function(data) {
        var transformed = {}
        var pag = data.pagination

        transformed.pagination = {
          total: pag.total,
          per_page: pag.per_page,
          current_page: pag.current_page,
          last_page: pag.last_page,
          next_page_url: pag.next_page_url,
          prev_page_url: pag.prev_page_url,
          from: pag.from,
          to: pag.to
        }

        transformed.mydata = []

        transformed.mydata = pag.data

        for (var i = 0; i < pag.data.length; i++) {
          let ban_expired_at = false
          let user = pag.data[i]
          for(let ban of user.bans) {
            if(ban.expired_at === null) {
              ban_expired_at = true
              break
            }
            let date_expired = moment(ban.expired_at)
            if(ban_expired_at === false) {
              ban_expired_at = date_expired
            } else if(date_expired.isAfter(ban_expired_at)) {
              ban_expired_at = date_expired
            }
          }
          user.ban_expired_at = ban_expired_at
          user.ban_duration = false
          user.is_banned = false

          if(typeof ban_expired_at != 'boolean' && user.banned_at !== null && ban_expired_at.isAfter(data.current_date)) {
            user.ban_duration = moment.duration(moment(user.banned_at).diff(ban_expired_at)).humanize()
            user.is_banned = true
          }
          if(ban_expired_at === true) {
            user.ban_duration = true
            user.is_banned = true
          }
        }

        return transformed
      },

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
      bannedLabel (value) {
        if(value === true) {
          return '<span class="badge badge-danger">Permanent</span>'
        } else if (value !== false) {
          return '<span class="badge badge-danger">' + value + '</span>'
        }
      },
      verifiedLabel (value) {
        return value === null
          ? '<span class="badge badge-warning">No</span>' : ''
          //: '<span class="badge badge-success">Verified</span>'
      },
      createdAtLabel (value) {
        return moment(value).format("DD-MM-YYYY HH:mm")
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
          this.updateUserForm.bans_expired_at = data.is_banned === true && data.ban_expired_at !== true ? data.ban_expired_at.format("DD-MM-YYYY HH:mmZ") : data.is_banned
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
      onGroupBan() {
        this.dateTimeBanUsers = moment().add(1, 'minutes').format('DD-MM-YYYY HH:mmZ')
        this.$root.$emit('bv::show::modal','modal-ban-group-users')
      },

      onGroupDelete() {
        this.$root.$emit('bv::show::modal','modal-delete-group-users')
      },

      async groupBan() {
        await axios.patch('/api/admin/users/group-ban', {
          ids: this.$refs.vuetable.selectedTo,
          expired_at: this.dateTimeBanUsers
        })
        this.$refs.vuetable.reload()
      },

      async groupDelete() {
        await axios.patch('/api/admin/users/group-delete', {
          ids: this.$refs.vuetable.selectedTo
        })
        this.$refs.vuetable.reload()
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
      },

      __getCurDateTimeMoment() {
        return moment()
      },

      __getCurDateTime () {
        return moment().format('DD-MM-YYYY HH:mmZ')
      },

      __timeIsFuture(time) {
        return moment(time, 'DD-MM-YYYY HH:mmZ').isSameOrAfter(moment())
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
  .vuetable th#_ban_duration {
    width: 100px;
  }
  .vuetable th#_email_verified_at {
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