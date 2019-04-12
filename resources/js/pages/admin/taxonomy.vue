<template lang="pug">
  .container-fluid.pl-6
    .row
      .col
        h1 {{$t('taxonomy')}}
        .row
          .col-6
            categories-edit
          .col-6
            tags-edit
</template>

<script>
  import Form from 'vform'
  import axios from 'axios'
  import _ from 'lodash'
  import Categories from "../../components/taxonomy-crud/Categories";
  import Tags from "../../components/taxonomy-crud/Tags";

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('menus') }
    },

    components: {
      'categories-edit': Categories,
      'tags-edit': Tags,
    },

    data: () => ({

    }),

    computed: {

    },

    methods: {

    },

    watch: {

    }
  }
</script>

<style lang="sass">

</style>