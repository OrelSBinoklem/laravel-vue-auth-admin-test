<template>

  <div class="table-menu-sub">
    <router-link
      class="link"
      :to="item.is_router ? __getRouterData(item) : {path: item.path}"
      active-class="active"
      @click.native.prevent="(e) => {onChangePage(item.slug, e)}"
    >
      <img
        class="nav-menu-icon-img"
        v-if="!!item.icon"
        :src="'/storage' + item.icon"
        alt=""
        :title="item.name"
      >
    </router-link>
    <div
      class="sub-item"
      v-if="!!item.children && !!item.children.length"
      v-for="itemSub in item.children"
    >
      <table-menu-sub-item
        :item="itemSub"
        @change-page="onChangePage"
      >
      </table-menu-sub-item>
    </div>
  </div>


</template>

<script>


export default {
  name: 'TableMenuSubItem',

  props: {
    item: {type: Object},
  },

  data() {
    return {
      
    }
  },

  computed: {

  },

  beforeMount() {

  },

  mounted () {},

  beforeDestroy() {},

  methods: {
    onChangePage(slug, e) {
      this.$emit('change-page', slug, e)
    },

    __getRouterData(item) {
      return {...item.router}
    }
  },

  watch: {}
}
</script>

<style lang="scss" scoped>
  .table-menu-sub {
    display: flex;
  }

  .link {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
  }

  .nav-menu-icon-img {
    max-width: 70%;
    max-height: 70%;
    height: auto;
    width: auto;
  }

  .sub-item {
    margin-top: 20px;
  }
</style>

<style lang="scss">

</style>