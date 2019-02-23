<template>
  <div class="row">
    <div class="col">
      <h1>{{$t('roles')}} / {{$t('permissions')}}</h1>
      <crud-table-permissions-roles></crud-table-permissions-roles>
      <div class="row">
        <div class="col-12 col-xl-6">
          <h1>{{$t('roles')}}</h1>
          <crud-table-roles></crud-table-roles>
        </div>
        <div class="col-12 col-xl-6">
          <h1>{{$t('permissions')}}</h1>
          <crud-table-permissions></crud-table-permissions>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import PermissionsRoles from "../../components/crud-tables/PermissionsRoles";
  import Roles from "../../components/crud-tables/Roles";
  import Permissions from "../../components/crud-tables/Permissions";

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('permissions') }
    },

    components: {
      'crud-table-permissions-roles': PermissionsRoles,
      'crud-table-roles': Roles,
      'crud-table-permissions': Permissions
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