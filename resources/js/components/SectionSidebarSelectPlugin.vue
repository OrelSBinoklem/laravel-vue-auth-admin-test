<template>


  <div class="nav-menu">
    <div class="nav-menu-filter">
      <template>
        <div
          class="nav-menu-column"
          v-for="(item, j) in filterCurrentGroup"
          :class="{active: item.slug === curFilter, 'active-cat': !!curFilterCats && curFilterCats.includes(item.slug)}"
          @click.prevent="(e) => {onSelectFilter(item.slug, e)}"
          :title="item.title"
        >
          <router-link class="nav-menu-one-col-icon" :to="item.is_router ? __getRouterData(item) : {path: item.path}" active-class="active">
            <img class="nav-menu-icon-img" v-if="!!item.icon" :src="'/storage' + item.icon" alt="">
          </router-link>
        </div>
      </template>

      <button @click="onFilterToggle" type="button" class="btn btn-default btn-open-filter-big"><fa icon="bars" size="lg"></fa></button>
    </div>

    <div v-if="filterBigOpened" class="filter-big">
      <TableMenu
        :menu="menuData"
        @change-page="onFilterChangePage"
      >
        <template slot="footer">
          <h6 class="heading">Ctrl + LClick - чтобы выбрать категорию без родительских</h6>
        </template>
      </TableMenu>
    </div>

    <div class="nav-menu-content">
      <bs-sidebar-menu-nested-drop v-if="!!menuNavDataFiltered" :menu="menuNavDataFiltered"></bs-sidebar-menu-nested-drop>
    </div>
  </div>


</template>

<script>
  import _ from 'lodash'
  import Vue from 'vue'

  import {menuHelpers} from '../components/menu-items/menu-helpers';
  import {getRenderedMenuDataMixin} from '../components/menu-items/get-rendered-menu-data-mixin';

  import TableMenu from '../components/table-menu/TableMenu';
  import BsSidebarMenuNestedDrop from '../components/bs-sidebar-menu-nested-drop/BsSidebarMenuNestedDrop';

export default {
  name: 'SectionSidebarSelectPlugin',

  mixins: [menuHelpers, getRenderedMenuDataMixin],

  components: {
    TableMenu,
    BsSidebarMenuNestedDrop
  },

  props: {
    curFilter: {type: String},
    curFilterCats: {type: Array},
    menuNav: {type: Array},
  },

  data() {
    return {
      filterBigOpened: false
    }
  },

  computed: {
    filterCurrentGroup () {
      return !!this.curFilter && !!this.menuData ? this.getFlat3LevelMenu(this.curFilter) : []
    },

    menuNavDataFiltered() {
      if(!!this.menuNav)
        if(!!this.curFilter)
          this.menuNav.forEach((cat) => {
            if('originalChildren' in cat && !!cat.originalChildren.length) {
              cat.children = cat.originalChildren.filter((item) => {
                if(_.hasIn(item, 'categories')) {
                  for(let cat of (Array.isArray(item.categories) ? item.categories : _.keysIn(item.categories)))
                    if(this.curFilterCats.includes(cat))
                      return true;
                  return false;
                }
                else
                  return true;
              });
            }
          });
        else
        if(!!this.menuNav)
          this.menuNav.forEach((cat) => {
            if('originalChildren' in cat && !!cat.originalChildren.length) {
              cat.children = cat.originalChildren.slice();
            }
          });
      return this.menuNav;
    },
  },

  async beforeMount() {
    await this.getDataMenuBySlug('categories-plugins');

    this.__setParent(this.menuData)
    //todo-hack чтобы работало getFlat3LevelMenu
    Vue.set(this, 'menuData', this.menuData.slice())

    document.body.addEventListener('click', this.onClickOutsidePosition)
  },

  mounted () {},

  beforeDestroy() {
    document.body.removeEventListener('click', this.onClickOutsidePosition)
  },

  methods: {
    onSelectFilter (slug, e) {
      if(e.ctrlKey)
        this.$emit('select-filter', slug, [slug])
      else {
        let items = !!this.menuData ? this.getFlat3LevelMenu(slug) : []
        let mainParent = items[0]
        let curItem = _.find(items, {slug})
        let slugsCats = []

        slugsCats.push(curItem.slug)
        while (mainParent !== curItem) {
          curItem = curItem.parent
          slugsCats.push(curItem.slug)
        }

        this.$emit('select-filter', slug, slugsCats)
      }
    },

    onFilterToggle () {
      this.filterBigOpened = !this.filterBigOpened
    },

    onFilterChangePage (slug, e) {
      this.filterBigOpened = false
      this.onSelectFilter(slug, e)
    },

    /**
     * Получаем все элементы которые находяться на 3-м уровне глубины и глубже вместе с элементом slug которого передаёться + 1 родительский
     * @param {String} slug - одного из элементов 3-го уровня и глубще или родительского на 2-м
     * @returns {[]}
     */
    getFlat3LevelMenu (slug) {
      let result = []
      let selectFlag = false
      loop1:
      for (let itemL1 of this.menuData)
        if (_.hasIn(itemL1, 'children')) {
          for (let itemL2 of itemL1.children) {
            if (itemL2.slug === slug) {
              if (_.hasIn(itemL2, 'children'))
                result = this.__treeToFlat(itemL2.children)
              result.unshift(itemL2)
              break loop1
            }

            if (_.hasIn(itemL2, 'children')) {
              result = this.__treeToFlat(itemL2.children)
              if (result.some((item) => {return item.slug === slug})) {
                if (!!result.length && !!result[0].parent)
                  result.unshift(result[0].parent)
                break loop1
              }
            }
          }
        }

      return result
    },

    onClickOutsidePosition(e) {
      if (!($(e.target).closest('.btn-open-filter-big, .filter-big').length)) {
        this.filterBigOpened = false
      }
    },

    __getRouterData(item) {
      return {...item.router}
    }
  },

  watch: {}
}
</script>

<style lang="scss" scoped>
  .nav-menu {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .nav-menu-filter {
    padding-top: 1px;
    position: relative;
    flex: 0 0 auto;
    display: flex;
    justify-content: center;
    min-height: 42px;
    background-color: #f7f9fb;
  }

  .nav-menu-column {
    position: relative;
    font-size: 12px;
    text-align: center;
    z-index: 1;
    border: 1px solid transparent;
    border-bottom: none;
    border-radius: 3px 3px 0 0;
    transition: border-color 0.2s ease-in-out;
    cursor: pointer;
  }

  .nav-menu-one-col-icon {
    padding: 0;
    outline: none;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    font-size: 18px;
    opacity: 0.5;
    filter: grayscale(1);
    transition: opacity 0.2s ease-in-out, filter 0.2s ease-in-out;
  }

  .nav-menu-column.active {
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-bottom: none;
    background: #fff;
  }

  .nav-menu-column.active-cat:after {
    content: "";
    position: absolute;
    top: 0;
    left: 25%;
    right: 25%;
    border-bottom: 2px solid #333;
  }

  .nav-menu-column.active:after {
    content: "";
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    border-bottom: 1px solid #fff;
  }

  .nav-menu-column.active .nav-menu-one-col-icon {
    opacity: 1;
    filter: none;
  }

  .nav-menu-filter:hover {
    .nav-menu-one-col-icon {
      opacity: 1;
      filter: none;
    }
  }

  .nav-menu-icon-img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 70%;
    max-height: 70%;
    height: auto;
    width: auto;
  }

  .btn-open-filter-big {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    &.btn:focus {
      box-shadow: none;
    }
  }

  .filter-big {
    position: absolute;
    top: 0;
    left: 100%;
    background: #fff;
    box-shadow: 5px 5px 5px -5px rgba(0, 0, 0, 0.5);
  }

  .filter-big .heading {
    margin-top: 15px;
    margin-bottom: 0;
    padding-left: 15px;
  }

  .nav-menu-content {
    flex-grow: 1;
    flex-basis: 0;
    min-height: 0;
  }
</style>

<style lang="scss">

</style>