import axios from 'axios'
import _ from 'lodash'
var qs = require('qs');

export const types = {
  1: {
    component: 'Casual',
    typeName: 'Ссылка',
    async loadSpecialData(store, items) {

    }
  },
  2: {
    component: 'SingleMaterial',
    typeName: 'Материал',
    async loadSpecialData(store, items) {
      let slugs = {}
      let temp = items.slice()
      _.remove(temp, function(item) {
        return item.type_id !== 2;
      });

      temp.forEach((item) => {
        if(!(item.meta_data.content_type in slugs)) {
          slugs[item.meta_data.content_type] = []
        }
        slugs[item.meta_data.content_type].push(item.meta_data.material_slug)
      })

      await axios
        .get('/api/content/get-some-items', {
          params: {'material-slugs': slugs},
          'paramsSerializer': function(params) {
            return qs.stringify(params)
          },
        })
        .then(response => {
          store.dispatch('menu/setAdminMaterials', response.data)
        }).catch(err => (console.log(err)))
    }
  },
  3: {
    component: 'Category',
    typeName: 'Категория',
    async loadSpecialData(store, items) {
      await store.dispatch('db/loadCategories')
    }
  }
}