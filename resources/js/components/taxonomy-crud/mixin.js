import Form from 'vform'
import axios from 'axios'
import * as th from 'tree-helper'

export const mixin = {
  props: {
    maxLevel: {
      type: Number,
      default: 3
    }
  },

  mounted: function () {
    axios
      .get('/api/admin/' + this.type)
      .then(response => {
        var items = response.data
        if(this.type == 'categories') {
          this.__setOpenedItems(items)
          items = this.__flatToTreeArray(items)
          this.__setNotPublishParent(items)
        }
        this.items = items
      }).catch(err => (console.log(err)))
  },

  data() {
    return {
      curItem: null,
      items: null,

      addForm: new Form({
        title: '',
        slug: '',
        published: true
      }),

      updateForm: new Form({
        title: '',
        slug: '',
        published: true
      }),
    }
  },

  created() {

  },

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

    async onAddItem () {
      this.addForm.reset()
      this.$root.$emit('bv::show::modal', 'modal-create-' + this.typeOne)
    },

    async addItem() {
      await this.addForm.post('/api/admin/' + this.type)
      this.$root.$emit('bv::hide::modal','modal-create-' + this.typeOne)
      this.__reloadItems()
    },

    async onUpdate (data) {
      this.curItem = data
      this.updateForm.reset()
      this.updateForm.title = data.title
      this.updateForm.slug = data.slug
      this.updateForm.published = !!data.published
      this.$root.$emit('bv::show::modal','modal-update-' + this.typeOne)
    },

    async updateItem() {
      await this.updateForm.put('/api/admin/' + this.type + '/' + this.curItem.id)
      this.$root.$emit('bv::hide::modal','modal-update-' + this.typeOne)
      this.__reloadItems()
    },

    async onDelete (data) {
      this.curItem = data
      this.$root.$emit('bv::show::modal','modal-delete-' + this.typeOne)
    },

    __isPlaceholder () {
      return 'isDragPlaceHolder' in this.curItem
    },

    __reloadItems() {
      axios
        .get('/api/admin/' + this.type)
        .then(response => {
          var items = response.data
          if(this.type == 'categories') {
            this.__setOpenedItems(items)
            items = this.__flatToTreeArray(items)
            this.__setNotPublishParent(items)
          }
          this.items = items
        }).catch(err => (console.log(err)))
    }
  },

  computed: {

  },

  watch: {

  }
}