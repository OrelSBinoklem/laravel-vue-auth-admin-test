<template>
    <div class="container">
      <main-menu v-if="!!menuData && !!menuData.length" :items="menuData" />
    </div>
</template>

<script>
import {getRenderedMenuDataMixin} from '../components/menu-items/get-rendered-menu-data-mixin';
import {menuHelpers} from '../components/menu-items/menu-helpers';

import MainMenu from '../components/p-home/MainMenu';

export default {
  layout: 'empty',
  middleware: [],

  metaInfo () {
    return { title: this.$t('home') }
  },

  mixins: [menuHelpers, getRenderedMenuDataMixin],

  components: {
    MainMenu
  },

  async beforeMount() {
    await this.getDataMenuBySlug('main');
  }
}
</script>


<style lang="scss" scoped>
  .container {
    padding: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
</style>