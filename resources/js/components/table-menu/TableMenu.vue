<template>


    <div class="table-menu">
      <div
        class="level1"
        v-for="level1 in menu"
      >
        <div class="nav-menu-icon-wrap">
          <img
            class="nav-menu-icon-img"
            v-if="!!level1.icon"
            :src="'/storage' + level1.icon"
            alt=""
          >
        </div>
        <div class="level1-sub-wrap">
          <div
            class="sub-item"
            v-if="!!level1.children && !!level1.children.length"
            v-for="itemSub in level1.children"
          >
            <table-menu-sub-item
              :item="itemSub"
              @change-page="onChangePage"
            ></table-menu-sub-item>
          </div>
        </div>
      </div>
      <slot name="footer"></slot>
    </div>


</template>

<script>

export default {
  name: 'TableMenu',
  props: {
    menu: {type: Array},
  },

  data() {
    return {

    }
  },

  computed: {

  },

  async beforeMount() {},

  mounted () {},

  beforeDestroy() {},

  methods: {
    onChangePage (slug, e) {
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
  .table-menu {
    padding: 15px 15px 15px 0;
    overflow: hidden;
    background: #f7f9fb;
  }

  .level1 {
    display: flex;
  }

  .level1:nth-child(n + 2) {
    margin-top: 15px;
  }
  
  .nav-menu-icon-wrap {
    position: relative;
    width: 80px;
    height: 80px;
  }

  .nav-menu-icon-img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 70%;
    max-height: 70%;
    height: auto;
    width: auto;
  }

  .level1-sub-wrap {
    display: flex;
    background: #fff;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
  }

  .sub-item {
    display: flex;
  }
</style>

<style lang="scss">

</style>