<template lang="pug">


  .sub-item(ref="container").clearfix
    .dropdown-menu.show
      template(v-for="item in items")
        router-link(
          v-if='item.is_router',
          :to='__getRouterData(item)',
          active-class='active'
          @mouseenter.native="(e) => {onHover(e, item)}"
          @mouseleave.native="onBloor"
          @click.native="onChangePage"
        ).dropdown-item.d-flex.justify-content-between.align-items-center
          | {{item.name}}
          span.arrow-sub(v-if="!!item.children && !!item.children.length")
        a(
          v-else='',
          :href='item.path'
          @mouseenter="(e) => {onHover(e, item)}"
          @mouseleave="onBloor"
          @click="onChangePage"
        ).dropdown-item.d-flex.justify-content-between.align-items-center
          | {{item.name}}
          span.arrow-sub(v-if="!!item.children && !!item.children.length")
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

export default {
  name: 'BsSidebarMenuNestedDropSubItem',
  mixins: [mixin],
  props: {
    items: {type: Array, required: true}
  },

  data() {
    return {
      isSub: true
    }
  },

  methods: {
    __getRouterData(item) {
      return {...item.router};
    },
  },

  watch: {

  }
}
</script>

<style lang="scss" scoped>
  .dropdown-menu {
    position: static;
    margin-top: -1px;
  }

  .dropdown-item {
    padding-right: 5px;
  }

  .arrow-sub {
    transform: rotate(-90deg);

    display: inline-block;
    width: 0;
    height: 0;
    margin-left: .255em;
    vertical-align: .255em;
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
  }
</style>

<style lang="scss">

</style>