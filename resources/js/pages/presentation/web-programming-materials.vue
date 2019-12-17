<template>

</template>

<script>
  import {contentTypes} from "../../components/content-types/contentTypes";
  import _ from 'lodash'

  import {mContentHashes} from '../../components/scroll-hash/mContentHashes'

  export default {
    layout: 'plain-plugins',

    metaInfo () {
      //todo-orel перевод
      const { appName } = window.config

      return {
        title: 'Вэб-программирование',
        titleTemplate: `${appName} - %s`
      }
    },

    mixins: [mContentHashes],

    components: {

    },

    data() {
      return {

      }
    },

    methods: {
      onLoad(data) {
        this.$store.dispatch('interface/setNavHashes', this.parseHashes({}))

      }
    },

    created() {
      this.$store.dispatch('interface/setHashGroups', _.find(contentTypes.get().contentTypes, {slug: 'js-plugin'}).hashGroups)
    },

    mounted: function () {

    }
  }
</script>