<template>
  <show @load="onLoad"></show>
</template>

<script>
  import Show from "../../components/content-types/js-plugin/Show";
  import {contentTypes} from "../../components/content-types/contentTypes";
  import _ from 'lodash'

  import {mContentHashes} from '../../components/scroll-hash/mContentHashes'

  export default {
    layout: 'plain-plugins',

    metaInfo () {
      //todo-orel перевод
      return {
        title: '',
        titleTemplate: 'Простая зборка - %s'
      }
    },

    mixins: [mContentHashes],

    components: {
      Show
    },

    methods: {
      onLoad(data) {
        this.$store.dispatch('interface/setNavHashes', this.parseHashes(data.meta_data.positions))

      }
    },

    created() {
      this.$store.dispatch('interface/setHashGroups', _.find(contentTypes.get().contentTypes, {slug: 'js-plugin'}).hashGroups)
    }
  }
</script>