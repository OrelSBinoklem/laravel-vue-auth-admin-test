<template lang="pug">
  div.tree-menu-items-edit(@mouseenter="onMouseenter" @mouseleave="onMouseleave"
    :class="{'__mode-toggle-branches': componentMouseEntered && ctrlPressed}")
    b-button.btn-collapse-all(variant='primary' @click='onCollapseAll').mb-3 collapse all
    b-button.btn-expand-all(variant='primary' @click='onExpandAll').ml-3.mb-3 expand all
    b-button(id="tooltip-tree-menu-items-edit-collapsed-tree" variant='outline-primary').ml-3.mb-3 Ctrl + LClick ?
    b-tooltip(target="tooltip-tree-menu-items-edit-collapsed-tree" triggers="hover") <b>Ctrl + LClick по плюсу или минусу - разворачивает или сворачивает всю ветку пунктов меню соответственно!</b>
    //todo-mark vue-draggable-nested-tree(:indent="30") связано с $pl-item-level
    //todo-mark vue-draggable-nested-tree(:space="5") связано с $mb-item
    vue-draggable-nested-tree(:data="items" draggable crossTree ref="tree1" @drag="ondrag" @change="onchange" :space="5" :indent="30")
      div(slot-scope="{data, store}", :key="data.id")
        menu-item(
          :data="data"
          :edit="true"
          :menuId="menuId"
          :collapsed="__itemOpened(data.id)"
          @update="onUpdate"
          @delete="onDelete"
          @toggle="onToggle"
          @toggle-branch-collapse="onToggleBranchCollapse")
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
        //todo-mark тут нужен глобальный обработчик нажатий клавиш, а то когда модульпоявиться непонятно нажата ли клавиша Ctrl, хотя это неважно потому что работь фишка будет только при наведении на модуль и именно при наведении будет дополнительно проверяться клавиша Ctrl
        ctrlPressed: false,
        componentMouseEntered: false,
        curDeleteItemData: null
      }
    },
    // computed: {},
    watch: {

    },
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

      onToggleBranchCollapse (item) {
        let id = item.id;
        let ids = [];
        let open = !item.open;

        if(this.componentMouseEntered && this.ctrlPressed) {

          function recursion(items, allChild) {
            items.forEach((item) => {
              if(item.id === id || !!allChild) {

                item.open = open;
                ids.push(item.id);

                allChild = true;
              }

              if('children' in item && item.children.length) {
                recursion(item.children, allChild);
              }

              if(item.id === id) {
                allChild = false;
              }
            });
          }
          recursion(this.items, false);

        } else {
          ids.push(id);
          item.open = open;
        }

        this.$emit('toggle-branch-collapse', {open: open, itemsIds: ids});
      },

      onCollapseAll() {
        let res = {open: false, itemsIds: []};

        function recursion(items) {
          items.forEach((item) => {
            item.open = false;
            res.itemsIds.push(item.id);

            if('children' in item && item.children.length) {
              recursion(item.children);
            }
          });
        }

        recursion(this.items);

        this.$emit('collapse-all', res);
      },

      onExpandAll() {
        let res = {open: true, itemsIds: []};

        function recursion(items) {
          items.forEach((item) => {
            item.open = true;
            res.itemsIds.push(item.id);

            if('children' in item && item.children.length) {
              recursion(item.children);
            }
          });
        }

        recursion(this.items);

        this.$emit('expand-all', res);
      },

      onMouseenter(e) {
        this.ctrlPressed = e.ctrlKey;
        this.componentMouseEntered = true;
      },

      onMouseleave(e) {
        this.ctrlPressed = e.ctrlKey;
        this.componentMouseEntered = false;
      },

      handlerKeydown(e) {
        this.ctrlPressed = e.ctrlKey;
      },

      handlerKeyup(e) {
        this.ctrlPressed = e.ctrlKey;
      },

      __itemOpened (id) {
        if(!(id in this.openedItems)) {
          return false
        }

        return this.openedItems[id]
      },
    },

    created() {
      window.addEventListener('keydown', this.handlerKeydown);
      window.addEventListener('keyup', this.handlerKeyup);
    },

    // mounted() {},

    beforeDestroy() {
      window.removeEventListener('keydown', this.handlerKeydown);
      window.removeEventListener('keyup', this.handlerKeyup);
    }
  }
</script>

<style lang="sass">
  //todo-mark $pl-item-level связано с vue-draggable-nested-tree(:indent="30")
  $pl-item-level: 30px
  //todo-mark vue-draggable-nested-tree(:space="5") связано с $mb-item
  $mb-item: 5px
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
    .tree-node
      position: relative
    .tree-node.open > .tree-node-inner-back > .tree-node-inner > div > .menu-item > .btn-uncollapsed:after
      content: ''
      position: absolute
      top: 50%
      right: 50%
      bottom: 0
      border-left: 1px solid #999
    .tree-node.open > .tree-node-inner-back > .tree-node-inner > div > .menu-item.__not-child > .btn-uncollapsed:after
      display: none
    .tree-node.open > .tree-node-children > .tree-node:before
      content: ''
      position: absolute
      top: -$mb-item
      left: -16px
      bottom: 0
      border-left: 1px solid #999
    .tree-node .tree-node .tree-node.open > .tree-node-children > .tree-node:before
      left: -16px + $pl-item-level
    .tree-node .tree-node .tree-node .tree-node.open > .tree-node-children > .tree-node:before
      left: -16px + $pl-item-level * 2
    .tree-node .tree-node .tree-node .tree-node .tree-node.open > .tree-node-children > .tree-node:before
      left: -16px + $pl-item-level * 3
    .tree-node.open > .tree-node-children > .tree-node > .tree-node-inner-back > .tree-node-inner > div > .menu-item > .btn-uncollapsed:before
      content: ''
      position: absolute
      top: 50%
      right: 50%
      width: 100%
      border-bottom: 1px solid #999
    &.__mode-toggle-branches .btn-uncollapsed:hover
      background-color: #ccc
</style>