import { mapGetters } from 'vuex'
import axios from 'axios'

export const mixinMenu = {
  metaInfo () {
    return {

    }
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
      current: 'content-widgets/selected'
    })
  },
  watch: {

  },
}