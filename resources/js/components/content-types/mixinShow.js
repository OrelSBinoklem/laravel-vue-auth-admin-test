import { mapGetters } from 'vuex'
import axios from 'axios'

import ClientPositionWidget from '../content-widgets/ClientPositionWidget'

export const mixinShow = {
  metaInfo () {
    return {
      //todo-orel когда передаёш пустую строку то оно выводит в титле undefined
      title: this.data !== null ? this.data.meta_title : ' ',
      meta: [
        { hid: 'description', name: 'description', content: this.data !== null ? this.data.meta_description : '' },
        { hid: 'keywords', name: 'keywords', content: this.data !== null ? this.data.meta_keyword : '' }
      ]
    }
  },

  components: {
    ClientPositionWidget
  },

  props: {

  },

  data() {
    return {

    }
  },
  created() {

  },
  methods: {

  },
  computed: {
    ...mapGetters({
      language: 'lang/locale'
    })
  },
  watch: {
    '$route.params': function(newVal, oldVal){
      this.__loadItem(newVal.slug)
    },
  },
}