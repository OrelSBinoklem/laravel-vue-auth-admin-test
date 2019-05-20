<template lang="pug">
  div.tree-menu-items-edit
    vue-draggable-nested-tree(:data="items" draggable crossTree ref="tree1" @drag="ondrag" @change="onchange" :space="5" :indent="30")
      div(slot-scope="{data, store}", :key="data.id")
        menu-item(:data="data" :edit="true" :menuId="menuId" :collapsed="__itemOpened(data.id)" @update="onUpdate" @delete="onDelete" @toggle="onToggle")
    b-modal#modal-delete-menu-item(ref='modal-delete-menu-item', title='Точно удалить?')
      template(slot='modal-footer')
        b-button(size='sm', variant='secondary', @click='cancelModal') Нет
        b-button(size='sm', variant='primary', @click='onDeleteMenuItem') Удалить
        b-button(size='sm', variant='danger', @click='onDeleteMenuItemNested') Удалить с вложенными пунктами
    b-modal#modal-delete-menu-item-what-new-parent(ref='modal-delete-menu-item-what-new-parent', title='Куда переместить дочерние элементы?')
      template(slot='modal-footer')
        b-button(size='sm', variant='secondary', @click='cancelModal2') Отмена
        b-button(size='sm', variant='primary', @click='onDeleteMenuItemParentNull') В корень
        b-button(size='sm', variant='primary', @click='onDeleteMenuItemParentParent') В родителя удалённого пункта
</template>

<script>
  import axios from 'axios'
  import * as th from 'tree-helper'
  import MenuItem from "./MenuItem"

  export default {
    name: 'MenuItemsEdit',

    props: {
      maxLevel: {
        type: Number,
        default: 4
      },
      items: {
        type: Array,
        default: []
      },
      menuId: {
        type: Number,
        required: true
      },
      openedItems: {
        type: Object,
        required: true
      },
    },

    components: {
      'menu-item': MenuItem,
    },

    data() {
      return {
        curDeleteItemData: null
      }
    },
    // computed: {},
    // watch: {},
    ////////////////////////////////////this.$emit('update:title', newTitle)
    methods: {
      ondrag(node) {
        const {maxLevel} = this
        let nodeLevels = 1
        th.depthFirstSearch(node, (childNode) => {
          if (childNode._vm.level > nodeLevels) {
            nodeLevels = childNode._vm.level
          }
        })
        nodeLevels = nodeLevels - node._vm.level + 1
        const childNodeMaxLevel = maxLevel - nodeLevels
        //
        th.depthFirstSearch(this.items, (childNode) => {
          if (childNode === node) {
            return 'skip children'
          }
          if (!childNode._vm) {
            console.log(childNode);
          }
          this.$set(childNode, 'droppable', childNode._vm.level <= childNodeMaxLevel)
        })
      },

      onchange() {
        var order = 1
        var result = []
        ;(function recursion(items, parent_id) {
          items.forEach((item) => {
            result.push({id: item.id, parent_id, order})
            order++
            if('children' in item) {
              recursion(item.children, item.id)
            }
          })
        })(this.items, null)

        axios.put('/api/admin/menus/' + (this.menuId) + '/items-update-tree', {data: result})
      },

      onUpdate () {
        this.$emit('update')
      },

      async onDelete (e) {
        if(e.hasNested) {
          this.curDeleteItemData = e
          this.$root.$emit('bv::show::modal','modal-delete-menu-item')
        } else {
          await axios.delete('/api/admin/menus/' + (e.menu_id) + '/items/' + e.item_id)
          this.$emit('delete')
        }
      },

      async onDeleteMenuItem () {
        if(this.curDeleteItemData.hasParent) {
          this.$root.$emit('bv::hide::modal', 'modal-delete-menu-item')
          this.$root.$emit('bv::show::modal','modal-delete-menu-item-what-new-parent')
        } else {
          await axios.delete('/api/admin/menus/' + (this.curDeleteItemData.menu_id) + '/items/' + this.curDeleteItemData.item_id,{
            data: {
              new_parent: null
            }
          })
          this.$root.$emit('bv::hide::modal', 'modal-delete-menu-item')
          this.$emit('delete')
        }
      },

      async onDeleteMenuItemParentNull () {
        await axios.delete('/api/admin/menus/' + (this.curDeleteItemData.menu_id) + '/items/' + this.curDeleteItemData.item_id,{
          data: {
            new_parent: null
          }
        })
        this.$emit('delete')
      },

      async onDeleteMenuItemParentParent () {
        await axios.delete('/api/admin/menus/' + (this.curDeleteItemData.menu_id) + '/items/' + this.curDeleteItemData.item_id,{
          data: {
            new_parent: this.curDeleteItemData.parent_id
          }
        })
        this.$emit('delete')
      },

      async onDeleteMenuItemNested () {
        await axios.delete('/api/admin/menus/' + (this.curDeleteItemData.menu_id) + '/items/' + this.curDeleteItemData.item_id,{
          data: {
            delete_children: true
          }
        })

        this.$root.$emit('bv::hide::modal', 'modal-delete-menu-item')

        this.$emit('delete')
      },

      cancelModal () {
        this.$root.$emit('bv::hide::modal', 'modal-delete-menu-item')
      },

      cancelModal2 () {
        this.$root.$emit('bv::hide::modal', 'modal-delete-menu-item-what-new-parent')
      },

      onToggle (e) {
        this.$emit('toggle', e)
      },

      __itemOpened (id) {
        if(!(id in this.openedItems)) {
          return false
        }

        return this.openedItems[id]
      }
    },
    // created() {},
    // mounted() {},
  }
</script>

<style lang="sass">
  .tree-menu-items-edit
    .tree-node-inner-back
      box-sizing: content-box
      width: calc(100% - 90px)
    .tree-node-children .card
      border-left-width: 2px
    .tree-node-children .tree-node-children .card
      border-left-color: #dc3545 !important
    .tree-node-children .tree-node-children .tree-node-children .card
      border-left-color: #28a745 !important
    .tree-node-children .tree-node-children .tree-node-children .tree-node-children .card
      border-left-color: #007bff !important
</style>