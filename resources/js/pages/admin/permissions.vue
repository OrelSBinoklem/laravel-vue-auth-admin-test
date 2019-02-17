<template>
  <div class="row">
    <div class="col">
      <h1>{{$t('permissions')}}</h1>
      <crud-table-permissions-roles></crud-table-permissions-roles>
    </div>
  </div>
</template>

<script>
  import PermissionsRoles from "../../components/crud-tables/PermissionsRoles";

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('permissions') }
    },

    components: {
      'crud-table-permissions-roles': PermissionsRoles
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

<style lang="sass" scoped>

</style>