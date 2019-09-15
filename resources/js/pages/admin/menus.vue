<template>
  <div class="container-fluid pl-6">
    <div class="row">
      <div class="col">
        <div class="row">
          <div class="col-auto">
            <h1>{{$t('menus')}}</h1>
          </div>
          <div class="col">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
              <div class="btn-group mr-2" role="group" aria-label="First group">
                <button @click="onAddMenu" type="button" class="btn btn-success"><fa icon="plus" size="lg"/></button>
              </div>
              <div class="btn-group mr-2" role="group" aria-label="First group">
                <button @click="currentMenu !== null ? onUpdateMenu($event) : null" type="button" class="btn btn-warning" :class="{disabled: currentMenu === null}"><fa :icon="['far', 'edit']" size="lg"/></button>
              </div>
              <div class="btn-group" role="group" aria-label="First group">
                <button @click="currentMenu !== null ? onDeleteMenu($event) : null" type="button" class="btn btn-danger" :class="{disabled: currentMenu === null}"><fa :icon="['far', 'trash-alt']" size="lg"/></button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-2">
            <div class="list-group" v-if="menus.length">
              <template v-for="(menu, i) in menus">
                <router-link :to="{ name: 'admin.menu.slug', params: { slug: menu.slug }}" active-class="active" class="list-group-item list-group-item-action" :key="menu.slug">{{menu.name}}</router-link>
              </template>
            </div>
            <div v-else class="alert alert-primary" role="alert">
              Нет меню!
            </div>
          </div>
          <div class="col-10">
            <div class="row" v-if="items !== null">
              <div class="col-6">
                <menu-items-edit
                  :items.sync="items"
                  :itemsSpecialData="itemsSpecialData"
                  :maxLevel="4"
                  :menuId="currentMenu.id"
                  :openedItems="openedItems"
                  @update="onUpdate"
                  @delete="onDelete"
                  @toggle="onToggle"
                  @toggle-branch-collapse="onToggleBranchCollapse"
                ></menu-items-edit>
              </div>
              <div class="col-6">
                <menu-items-add :items.sync="items" :itemsSpecialData="itemsSpecialData" :menuId="currentMenu.id" @store="onStore"></menu-items-add>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <b-modal id="modal-create-menu"
             ref="modal-create-menu"
             title="Добавить меню"
             hide-footer>
      <form @submit.prevent="addMenu" @keydown="addMenuForm.onKeydown($event)" action="" method="post">

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="addMenuForm.name" :class="{ 'is-invalid': addMenuForm.errors.has('name') }" class="form-control" type="text" name="name">
            <has-error :form="addMenuForm" field="name"/>
          </div>
        </div>

        <!-- Slug -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('slug') }}</label>
          <div class="col-md-7">
            <input v-model="addMenuForm.slug" :class="{ 'is-invalid': addMenuForm.errors.has('slug') }" class="form-control" type="text" name="slug">
            <has-error :form="addMenuForm" field="slug"/>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex">
            <!-- Submit Button -->
            <v-button block :loading="addMenuForm.busy">
              Добавить меню
            </v-button>
          </div>
        </div>
      </form>
      <template slot="modal-cancel">Нет</template>
      <template slot="modal-ok">Да</template>
    </b-modal>
    <b-modal id="modal-update-menu"
             ref="modal-update-menu"
             :title="'Обновить меню &quot;' + (this.currentMenu ? this.currentMenu.name : '') + '&quot;?'"
             hide-footer>
      <form @submit.prevent="updateMenu" @keydown="updateMenuForm.onKeydown($event)" action="" method="post">

        <!-- Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
          <div class="col-md-7">
            <input v-model="updateMenuForm.name" :class="{ 'is-invalid': updateMenuForm.errors.has('name') }" class="form-control" type="text" name="name">
            <has-error :form="updateMenuForm" field="name"/>
          </div>
        </div>

        <!-- Slug -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('slug') }}</label>
          <div class="col-md-7">
            <input v-model="updateMenuForm.slug" disabled :class="{ 'is-invalid': updateMenuForm.errors.has('slug') }" class="form-control" type="text" name="slug">
            <has-error :form="updateMenuForm" field="slug"/>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex">
            <!-- Submit Button -->
            <v-button block :loading="updateMenuForm.busy">
              Обновить меню
            </v-button>
          </div>
        </div>
      </form>
      <template slot="modal-cancel">Нет</template>
      <template slot="modal-ok">Да</template>
    </b-modal>
    <b-modal id="modal-delete-menu"
             ref="modal-delete-menu"
             :title="'Точно удалить меню &quot;' + (this.currentMenu ? this.currentMenu.name : '') + '&quot;?'"
             @ok="deleteMenu">
      <template slot="modal-cancel">Нет</template>
      <template slot="modal-ok">Да</template>
    </b-modal>
  </div>
</template>

<script>
  import Form from 'vform'
  import axios from 'axios'
  import _ from 'lodash'
  import MenuItemsEdit from "../../components/menu-items/MenuItemsEdit";
  import MenuItemsAdd from "../../components/menu-items/MenuItemsAdd";
  import {types} from "../../components/menu-items/types-data"

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('menus') }
    },

    components: {
      'menu-items-edit': MenuItemsEdit,
      'menu-items-add': MenuItemsAdd,
    },

    mounted: function () {
      axios
        .get('/api/admin/menus')
        .then(response => {
          this.menus = response.data

          if(this.$route.name === "admin.menu.slug") {
            var menu = _.find(this.menus, {"slug": this.$route.params.slug})
            if(menu) {
              this.currentMenu = menu
            } else {
              this.currentMenu = null
              this.$router.push({ name: 'admin.menu'})
            }
          } else {
            if(this.menus.length) {
              this.currentMenu = this.menus[0]
              this.$router.push({ name: 'admin.menu.slug', params: { slug:  this.menus[0].slug} })
            } else {
              this.currentMenu = null
            }
          }
        }).catch(err => (console.log(err)))
    },

    data: () => ({
      currentMenu: null,
      items: null,
      itemsSpecialData: null,
      openedItems: {},
      openedItemsBranches: {},
      menus: [],

      addMenuForm: new Form({
        name: '',
        slug: ''
      }),

      updateMenuForm: new Form({
        name: '',
        slug: ''
      }),
    }),

    computed: {

    },

    methods: {
      async onAddMenu () {
        this.addMenuForm.reset()
        this.$root.$emit('bv::show::modal','modal-create-menu')
      },

      async onUpdateMenu () {
        this.updateMenuForm.reset()
        this.updateMenuForm.name = this.currentMenu.name
        this.updateMenuForm.slug = this.currentMenu.slug
        this.$root.$emit('bv::show::modal','modal-update-menu')
      },

      async onDeleteMenu () {
        this.$root.$emit('bv::show::modal','modal-delete-menu')
      },

      async addMenu() {
        var slug = this.addMenuForm.slug

        await this.addMenuForm.post('/api/admin/menus')

        this.$root.$emit('bv::hide::modal','modal-create-menu')

        await this._reloadMenus()

        this.$router.push({ name: 'admin.menu.slug', params: { slug:  slug} })
      },

      async updateMenu() {
        await this.updateMenuForm.put('/api/admin/menus/' + this.currentMenu.id)
        this.$root.$emit('bv::hide::modal','modal-update-menu')
        await this._reloadMenus()
      },

      async deleteMenu() {
        await axios.delete('/api/admin/menus/' + this.currentMenu.id)

        await this._reloadMenus()

        if(this.menus.length) {
          this.$router.push({ name: 'admin.menu.slug', params: { slug:  this.menus[0].slug} })
        } else {
          this.$router.push({ name: 'admin.menu'})
        }

        await this._reloadMenus()
      },

      async _reloadMenus() {
        await axios
          .get('/api/admin/menus')
          .then(response => {
            this.menus = response.data
          }).catch(err => (console.log(err)))
      },

      onStore () {
        this.__reloadItems()
      },

      onUpdate () {
        this.__reloadItems()
      },

      onDelete () {
        this.__reloadItems()
      },

      __flatToTreeArray(arr) {
        var r = []
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
        return r;
      },

      __treeSortedByOrder(arr) {
        arr = _.orderBy(arr, ['order'], ['asc']);
        arr.forEach((a) => {
          if(a.children && a.children.length) {
            a.children = this.__treeSortedByOrder(a.children)
          }
        }, Object.create(null))
        return arr;
      },

      __setNotPublishParent(arr, not_publish) {
        arr.forEach((a) => {
          if(not_publish === true) {
            a.not_publish_parent = true
          }
          if(a.children && a.children.length) {
            this.__setNotPublishParent(a.children, not_publish === true || a.publish == 0)
          }
        })
      },

      __reloadItems() {
        if(this.currentMenu) {
          axios
            .get('/api/admin/menus/' + (this.currentMenu.id) + '/items')
            .then(response => {
              for(let type in types) {
                types[type].loadSpecialData(this.$store, response.data)
              }

              var items = this.__treeSortedByOrder(this.__flatToTreeArray(response.data))
              this.__setNotPublishParent(items)
              this.items = items
            }).catch(err => (console.log(err)))
        } else {
          this.items = null
        }
      },

      onToggle (e) {
        this.openedItems[e.id] = e.collapsed
      },

      onToggleBranchCollapse (e) {
        this.openedItemsBranches[e.id] = e.open
      },
    },

    watch: {
      '$route.params': function(newVal, oldVal){
        if("slug" in newVal) {
          this.currentMenu = _.find(this.menus, {"slug": newVal.slug});
        } else {
          this.currentMenu = null
        }
      },

      currentMenu: function (menu) {
        if(menu) {
          axios
            .get('/api/admin/menus/' + (menu.id) + '/items')
            .then(response => {
              for(let type in types) {
                types[type].loadSpecialData(this.$store, response.data)
              }

              var items = this.__treeSortedByOrder(this.__flatToTreeArray(response.data))
              this.__setNotPublishParent(items)
              this.items = items
            }).catch(err => (console.log(err)))
        } else {
          this.items = null
        }
      },
      
      items: function (items) {
        items.forEach((item) => {
          if(item.id in this.openedItemsBranches) {
            item.open = this.openedItemsBranches[item.id];
          }
        });
      }
    }
  }
</script>

<style lang="sass" scoped>

</style>