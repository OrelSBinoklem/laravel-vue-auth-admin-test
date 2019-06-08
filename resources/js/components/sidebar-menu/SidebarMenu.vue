<template>
  <div class="v-sidebar-menu" :class="[!isCollapsed ? 'vsm-default' : 'vsm-collapsed']" :style="{'width': sidebarWidth}" @mouseleave="mouseLeave">
    <button class="collapse-btn" @click="toggleCollapse"><fa icon="bars" size="lg"/></button>
    <div class="vsm-list" :style="[{'height' : '100%'}]">
      <vue-scroll :ops="{bar: {background: '#4285f4'}, scrollPanel: {scrollingX: false}}">
        <template v-for="(item, index) in menu">
           <template v-if="item.header">
             <div v-if="!isCollapsed" :key="index" class="vsm-header">{{item.title.translate ? $t(item.title.translate) : item.title}}</div>
           </template>
           <item v-else :key="index" :item="item" :firstItem="true" :isCollapsed="isCollapsed" v-on:mouse-enter-item="mouseEnterItem" />
        </template>
      </vue-scroll>
    </div>
    <div v-if="isCollapsed" :style="[{'position' : 'absolute'}, {'top' : `${mobileItemPos}px`}, {'left' : '0px'}, {'padding-left' : sidebarWidth}, {'width' : width}]">
      <mobile-item :item="mobileItem" />
      <!--<transition name="slide-animation">-->
        <div class="vsm-mobile-bg" v-if="mobileItem" :style="[{'position' : 'absolute'}, {'left' : '0px'}, {'right' : '0px'}, {'top' : '0px'}, {'height' : `${mobileItemHeight}px`}]"></div>
      <!--</transition>-->
      <div class="vsm-dropdown" :style="[{'position' : 'absolute'}, {'top' : `${mobileItemHeight}px`}, {'left' : sidebarWidth}, {'right' : '0px'}, {'height' : mobileDropdownHeight != 'auto' ? `${mobileDropdownHeight}px` : 'auto'}, {'max-height' : `calc(100vh - ${mobileItemPos + mobileItemHeight}px)`}]">
        <vue-scroll :ops="{bar: {background: '#4285f4'}}">
          <!--<transition name="show-animation">-->
            <div class="vsm-list" ref="vsmList" v-if="mobileItem && mobileItem.child">
              <sub-item v-for="(subItem, index) in mobileItem.child" :item="subItem" :key="index"/>
            </div>
          <!--</transition>-->
        </vue-scroll>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import Item from './Item.vue'
import SubItem from './SubItem.vue'
import MobileItem from './MobileItem.vue'
import vuescroll from 'vuescroll';

Vue.use(vuescroll);

export default {
  name: 'SidebarMenu',
  components: {
    Item,
    SubItem,
    MobileItem
  },
  props: {
    menu: {
      type: Array,
      required: true
    },
    collapsed: {
      type: Boolean,
      default: false
    },
    width: {
      type: String,
      default: '350px'
    },
    widthCollapsed: {
      type: String,
      default: '50px'
    }
  },
  data() {
    return {
      sidebarWidth: this.collapsed ? this.widthCollapsed : this.width,
      isCollapsed: this.collapsed,
      mobileItem: null,
      mobileItemPos: 0,
      mobileItemHeight: 0,
      mobileDropdownHeight: 'auto'
    }
  },
  methods: {
    mouseLeave() {
      this.mobileItem = null
    },
    toggleCollapse() {
      this.isCollapsed = !this.isCollapsed
      this.sidebarWidth = this.isCollapsed ? this.widthCollapsed : this.width
      this.$emit('collapse', this.isCollapsed)
    },
    mouseEnterItem(val) {
      this.mobileItem = val.item
      this.mobileItemPos = val.pos
      this.mobileItemHeight = val.height
    }
  },
  watch: {
    mobileItem(val) {
      if(val && val.child) {
        this.$nextTick(() => this.mobileDropdownHeight = this.$refs.vsmList.clientHeight)
      } else {
        this.$nextTick(() => this.mobileDropdownHeight = 'auto')
      }
    }
  }
}
</script>

<style lang="scss">
  $primaryColor: #4285f4;
  $baseBg: #2a2a2e;
  $darkenBg: darken( $baseBg, 5% );
  $lightenBg: lighten( $baseBg, 5% );

  $textColor: #fff;

  .v-sidebar-menu, .v-sidebar-menu * {
    box-sizing: border-box;
  }

  .v-sidebar-menu {
    position: fixed;
    top: 0;
    left: 0;
    background-color: $baseBg;
    width: 100%;
    height: 100vh;
    padding-top: 50px;
    transition: 0.3s width;
    z-index: 1035;
  }

  .v-sidebar-menu .vsm-item {
    position: relative;
    display: block;
  }

  .v-sidebar-menu .vsm-item .vsm-link {
    position: relative;
    display: block;
    font-size: 16px;
    font-weight: 400;
    color: $textColor;
    padding: 10px;
    line-height: 30px;
    text-decoration: none;
    z-index: 20;
    transition: 0.3s all;
  }

  .v-sidebar-menu .vsm-item.first-item > .vsm-link:after {
    content: '';
    display: block;
    clear: both;
  }

  .v-sidebar-menu .vsm-item.first-item > .vsm-link > .vsm-title {
    display: block;
    white-space: nowrap;
  }

  .v-sidebar-menu .vsm-title {
    display: block;
    white-space: nowrap;
  }

  .v-sidebar-menu .vsm-icon {
    float: left;
    line-height: 30px;
    margin-right: 10px;
    color: $textColor;
  }
  .v-sidebar-menu.vsm-collapsed .vsm-icon {
    margin-right: 0;
  }
  .v-sidebar-menu .vsm-item.first-item > .vsm-link > .vsm-icon {
    height: 30px;
    line-height: 30px;
    width: 30px;
    text-align: center;
    background: $darkenBg;
    border-radius: 3px;
  }

  .v-sidebar-menu .vsm-arrow {
    width: 30px;
    text-align: center;
    font-style: normal;
    font-weight: 900;
    color: #ffff;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    transition: 0.3s transform;
  }
  .v-sidebar-menu .vsm-arrow.open-arrow {
    transform: translateY(-50%) rotate(90deg);
  }

  .v-sidebar-menu .vsm-dropdown .vsm-list {
    background: $lightenBg;
    padding: 5px;
  }

  .show-animation-enter-active {
    animation: show-animation .2s;
  }
  .show-animation-leave-active {
    animation: show-animation .2s reverse;
  }
  @keyframes show-animation {
    0% {
      opacity: 0;
      transform: scale(0.9);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }

  .v-sidebar-menu .vsm-mobile-bg {
    background-color: $primaryColor;
  }
  .slide-animation-enter-active {
    animation: slide-animation .2s;
  }
  .slide-animation-leave-active {
    animation: slide-animation .2s reverse;
  }
  @keyframes slide-animation {
    0% {
      width: 0%;
    }
    100% {
      width: 100%;
    }
  }

  .v-sidebar-menu.vsm-default .vsm-link:hover,
  .v-sidebar-menu .vsm-dropdown .vsm-list .vsm-link:hover {
    background-color: $darkenBg;
  }

  .v-sidebar-menu.vsm-default .vsm-item.first-item.open-item>.vsm-link {
    background: $primaryColor;
  }

  .v-sidebar-menu .vsm-item.first-item.active-item>.vsm-link {
    box-shadow: 3px 0px 0px 0px $primaryColor inset;
  }

  .v-sidebar-menu .vsm-item.active-item>.vsm-link {
    font-weight: 600;
  }

  .v-sidebar-menu .vsm-item.first-item.parent-active-item>.vsm-link {
    box-shadow: 3px 0px 0px 0px $primaryColor inset;
  }

  .v-sidebar-menu .vsm-item.parent-active-item>.vsm-link {
    font-weight: 600;
  }

  .v-sidebar-menu .vsm-header {
    color: rgba( $textColor, .7 );
    font-size: 14px;
    font-weight: 600;
    padding: 10px;
    white-space: nowrap;
    text-transform: uppercase;
  }

  .v-sidebar-menu .collapse-btn {
    display: block;
    color: $textColor;
    background-color: $darkenBg;
    text-align: center;
    font-style: normal;
    font-weight: 900;
    position: absolute;
    height: 50px;
    top: 0;
    left: 0;
    right: 0;
    cursor: pointer;
    border: none;
    width: 100%;
    outline: none;
  }

  /*for scroll*/
  .__vuescroll .__rail-is-vertical,
  .__vuescroll .__rail-is-horizontal {
    z-index: 20;
  }
</style>
