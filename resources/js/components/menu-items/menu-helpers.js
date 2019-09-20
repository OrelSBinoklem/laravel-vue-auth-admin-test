export const menuHelpers = {
  data() {
    return {

    }
  },

  methods: {
    async getFullMenuDataCache(slug) {
      let menuData = this.$store.getters['menu/menuClientBySlug'](slug)
      if(menuData) {
        return menuData
      } else {
        let loadedMenuData = await this.getFullMenuDataBySlug(slug)
        this.$store.dispatch('menu/setMenuClient', {
          slug: slug,
          menu: loadedMenuData
        })
        return loadedMenuData
      }
    },

    __treeToFlat(collection) {
      let result = [];

      for(let el of collection) {
        result.push(el)
        if('children' in el) {
          this.__treeToFlatRecursion(el.children, result)
        }
      }

      return result
    },

    __treeToFlatRecursion(collection, result) {
      for(let el of collection) {
        result.push(el)
        if('children' in el) {
          this.__treeToFlatRecursion(el.children, result)
        }
      }
    },

    __setParent(collection, parent) {
      if(parent) {
        for(let el of collection) {
          el.parent = parent
          if('children' in el) {
            this.__setParent(el.children, el)
          }
        }
      } else {
        let parentRoot = {children: collection}
        for(let el of collection) {
          el.parent = parentRoot
          if('children' in el) {
            this.__setParent(el.children, el)
          }
        }
      }
    }
  },
}