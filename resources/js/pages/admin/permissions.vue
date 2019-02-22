<template>
  <div class="row">
    <div class="col">
      <h1>{{$t('permissions')}}</h1>
      <crud-table-permissions-roles></crud-table-permissions-roles>
      <h1>{{$t('roles')}}</h1>
      <div class="row">
        <div class="col-12 col-lg-8 col-xl-6">
          <crud-table-roles></crud-table-roles>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PermissionsRoles from "../../components/crud-tables/PermissionsRoles";
  import Roles from "../../components/crud-tables/Roles";

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('permissions') }
    },

    components: {
      'crud-table-permissions-roles': PermissionsRoles,
      'crud-table-roles': Roles
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