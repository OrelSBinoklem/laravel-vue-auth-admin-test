<template lang="pug">


  .bs-sidebar-menu-nested-drop(ref="container")
    vue-scroll(:ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}" @handle-scroll="onScroll")
      .list-group
        template(v-for="item in menu")
          button(
            type='button'
            @mouseenter="(e) => {onHover(e, item)}"
            @mouseleave="onBloor"
            :class="{active: active === item}"
          ).list-group-item.list-group-item-action.d-flex.justify-content-between.align-items-center
            | {{item.name}}
            span(v-if="!!item.children && !!item.children.length" class="badge badge-primary badge-pill") {{item.children.length}}
    .contain-sub-item(
      v-if="!!active && !!active.children && !!active.children.length"
      :style="{top: calculateTopSubItem + 'px', opacity: topSubItemOpacity}"
      @mouseenter="onHoverSub"
      @mouseleave="onBloorSub"
    )
      BsSidebarMenuNestedDropSubItem(
        :items="active.children"
        @change-page="onChangePage"
      )


</template>

<script>

import Vue from 'vue'
import $ from 'jquery'
import _ from 'lodash';

import {mixin} from './mixin'

import vuescroll from 'vuescroll';
import SubItem from "./SubItem";
Vue.use(vuescroll);

export default {
  name: 'BsSidebarMenuNestedDrop',
  mixins: [mixin],
  components: {SubItem},
  props: {
    menu: {type: Array, required: true}
  },

  data() {
    return {
      isSub: false
    }
  },

  mounted() {

  },

  computed: {

  },

  methods: {
    onScroll() {
      this.topHoverItem = this.__getTopPositionItemByScroll(this.domActive);
    },

    onChangePage() {
      this.domActive = null;
      this.active = null;

      this.$emit('change-page');
    },
  },

  watch: {

  }
}
</script>

<style lang="scss" scoped>
  .bs-sidebar-menu-nested-drop {
    position: relative;
    height: 100%;
  }
</style>

<style lang="scss">
  .bs-sidebar-menu-nested-drop {
    .__rail-is-vertical {
      left: 2px;
      right: auto;
    }

    .contain-sub-item {
      position: absolute;
      left: calc(100% - 1px);
    }

    .sub-item {
      .contain-sub-item {
        left: calc(100% - 2px);
      }
    }
  }
</style>