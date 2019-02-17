<template>
  <div id='permissionsTable'>
    <!--ЗДЕЛАТЬ ВЫБРАТЬ ВСЁ ИЛИ СНЯТЬ ВСЁ-->
    <div class="row mx-0">
      <div class="col-4 col-lg-2 px-0">
        <table class="table table-sm table-bordered table-striped table-matrix-checkboxes">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Permissions\Roles</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(permission, index) in permissions" :key="permission.name" :class="permission.name === 'EDIT_PERMISSIONS' ? 'table-warning' : ''">
              <th scope="row">{{permission.name}}</th>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-8 col-lg-10 px-0">
        <vue-scroll :ops="vScroll">
          <table class="table table-sm table-bordered table-striped table-matrix-checkboxes">
            <thead>
              <tr>
                <th scope="col" class="text-nowrap" v-for="role in roles" :key="role.name">{{role.name}}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="permission in permissions" :key="permission.name" :class="permission.name === 'EDIT_PERMISSIONS' ? 'table-warning' : ''">
                <td v-for="(role, index) in roles" :key="role.name">
                  <label>
                    <b-form-checkbox-group v-model="roles[index].permissions" >
                      <b-form-checkbox :value="permission.id" @change="onChange($event, role.id, permission.id)"/>
                    </b-form-checkbox-group>
                  </label>
                </td>
              </tr>
            </tbody>
          </table>
        </vue-scroll>
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import axios from 'axios'
  import _ from 'lodash'
  import vuescroll from 'vuescroll';

  Vue.use(vuescroll);

  export default {
    name: "CrudTablePermissionsRoles",

    mounted: function () {
      axios
        .get('/api/admin/roles/get-permission-role-table')
        .then(response => {
          this.permissions = response.data.permissions
          this.roles = _.map(response.data.roles, (role) => {
            role.permissions = _.map(role.permissions, 'id')
            return role
          })
        }).catch(err => (console.log(err)))
    },

    data: () => ({
      permissions: [],
      roles: [],
      curEditRolRepRelations: {},

      vScroll: {
        mode: 'slide',
        bar: {
          background: 'rgb(24, 144, 255)',
          keepShow: true
        },
        rail: {
          border: '1px solid #cecece',
          size: '20px'
        },
        scrollButton: {
          enable: true,
          background: '#cecece'
        }
      }
    }),

    computed: {

    },

    methods: {
      async onChange (event, role_id, permission_id) {
        if(!(role_id + "-" + permission_id in this.curEditRolRepRelations)) {
          this.curEditRolRepRelations[role_id + "-" + permission_id] = true

          axios.patch('/api/admin/roles/change-permission-role', {
            attach: event !== null,
            role_id: role_id,
            permission_id: permission_id
          }).then(response => {
            delete this.curEditRolRepRelations[role_id + "-" + permission_id]
          }).catch(err => {
            let role = _.find(this.roles, {id: role_id})
            if(role) {
              let indexPerm = _.indexOf(role.permissions, permission_id)
              if(event !== null && indexPerm > -1) {
                role.permissions.splice(indexPerm, 1)
              }
              if(event === null && indexPerm == -1) {
                role.permissions.push(permission_id)
              }
            }
            delete this.curEditRolRepRelations[role_id + "-" + permission_id]
          })
        }
      }
    },

    watch: {

    }
  }
</script>

<style lang="sass" scoped>

</style>