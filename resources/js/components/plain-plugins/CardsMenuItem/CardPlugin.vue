<template lang="pug">


  .card-plugin(:class="{__cards: mode === 'cards', __list: mode === 'list'}")

    template(v-if="mode === 'cards'")

      .name(:title="data.name") {{data.name}}

      .tabs-select-wrap
        ul.tabs-select-plugin

          //Табы
          li(v-for='tab in visibleTabs' :class='{active: tab === curTab}')
            button(@click='onSelectPlugin(tab)')
              img(v-if="!!tab.icon" :src="'/storage' + tab.icon")
              .abbreviation(v-else) {{getAbbreviation(tab.name)}}

          //Дополнительные табы
          li(v-if='hasMore' :class="{active: isCurTabMore}" ref="more")
            button(@click="showMore")
              template(v-if="isCurTabMore")
                img(v-if="!!curTab.icon" :src="'/storage' + curTab.icon")
                .abbreviation(v-else) {{getAbbreviation(curTab.name)}}
              .icon-more: fa(:icon="['far', 'caret-square-down']" size="sm")
            .tabs-select-more(v-if="openedMoreTabs")
              .tabs-select-more-item(v-for='tab in moreTabs' :class='{active: tab === curTab}')
                button(@click='onSelectPlugin(tab)')
                  img(v-if="!!tab.icon" :src="'/storage' + tab.icon")
            .tabs-name-more(v-if="openedMoreTabs")
              .tabs-name-more-item(v-for='tab in moreTabs' :class='{active: tab === curTab}')
                button(@click='onSelectPlugin(tab)')
                  span.full-name {{tab.name}}

      .tab-content-wrap(@mouseleave="fixScrollAfterOpenLinkInNewTab" :class="{'first-tab-active': __isFirsTab(curTab), 'last-tab-active': __isLastTab(curTab) || isCurTabMore}")
        .tab-content(ref="tabContent" v-if="!!data.children && !!data.children.length")
          .name-content
            router-link(v-if='curTab.is_router', :to='__getRouterData(curTab)', active-class='active'): span(@click="onChangePage") {{ curTab.name }}
            a(v-else='', :href='curTab.path' @click="onChangePage") {{ curTab.name }}
          template(v-if="!!curTab && !!curTab.material")
            .desc {{curTab.material.description_short}}

            more-info(:data="curTab" :mode="mode" @change-page="onChangePage")

        .not-content(v-else) пусто

        .loader(v-if="showLoader"): b-spinner(type="grow")

    template(v-if="mode === 'list'")
      .list
        template(v-if="!!data.children && !!data.children.length")
          .list-plugin(v-for="tab in allTabs")
            .row
              .col-6
                .list-icon-name
                  span.list-name-link
                    router-link(v-if='tab.is_router', :to='__getRouterData(tab)', active-class='active')
                      span.list-name-link-wrap-ineer(@click="onChangePage")
                        span.list-icon(v-if="!!tab.icon")
                          img(:src="'/storage' + tab.icon")
                        span.list-name(:class="{'ml-0': !tab.icon}") {{ tab.name }}
                    a(v-else='', :href='tab.path')
                      span.list-name-link-wrap-ineer(@click="onChangePage")
                        span.list-icon(v-if="!!tab.icon")
                          img(:src="'/storage' + tab.icon")
                        span.list-name(:class="{'ml-0': !tab.icon}") {{ tab.name }}
                template(v-if="!!tab.material")
                  .list-desc {{tab.material.description_short}}
              .col-6
                template(v-if="!!tab.material")
                  more-info(:data="tab" :mode="mode" @change-page="onChangePage")
            .loader(v-if="!tab.material"): b-spinner(type="grow")

        .not-content(v-else) пусто


</template>

<script>

import $ from 'jquery'
import _ from 'lodash'

import MoreInfo from "./CardPlugin/MoreInfo";

export default {
  name: 'CardPlugin',

  components: {
    MoreInfo
  },

  props: {
    data: {type: Object, required: true},
    mode: {validator: function (value) {return ['cards', 'list'].indexOf(value) !== -1}, required: true},
    maxTabsLinkRow: {type: Number, default: 5},
    startPreload: {type: Number, default: 2},
    curNextPreload: {type: Number, default: 1},
  },

  data() {
    return {
      curTab: null,
      openedMoreTabs: false
    }
  },

  beforeMount() {
    this.__initCurTabAndLoadSpecialData();

    document.body.addEventListener('click', this.onClickOutsidePosition);
  },

  mounted () {

  },

  beforeDestroy() {
    document.body.removeEventListener('click', this.onClickOutsidePosition);
  },

  computed: {
    indexLastTab() {
      //todo-mark связано с шириной табов в css
      return this.maxTabsLinkRow - 1;
    },

    allTabs() {
      if(!!this.data.children && !!this.data.children.length)
        return this.data.children;
      return [];
    },

    visibleTabs() {
      if(!!this.data.children && !!this.data.children.length) {
        if(this.data.children.length > this.maxTabsLinkRow) {
          return this.data.children.slice(0, this.maxTabsLinkRow - 1);
        } else {
          return this.data.children;
        }
      }
      return [];
    },

    moreTabs() {
      if(!!this.data.children && !!this.data.children.length) {
        if(this.data.children.length > this.maxTabsLinkRow) {
          return this.data.children.slice(this.maxTabsLinkRow - 1);
        } else {
          return [];
        }
      }
      return [];
    },

    hasMore() {
      return !!this.moreTabs.length;
    },

    isCurTabMore() {
      for(let tab of this.moreTabs)
        if(this.curTab === tab)
          return true;
      return false;
    },

    showLoader() {
      return !!this.data.children && !!this.data.children.length && (!this.curTab || !this.curTab.material);
    }
  },

  methods: {
    onSelectPlugin(tab) {
      this.curTab = tab;

      if(this.curNextPreload > 0) {
        let index = _.findIndex(this.data.children, ['id', tab.id]);
        this.$emit('neded-materials', index + 1 < this.data.children.length ? this.data.children.slice(index, index + 1 + this.curNextPreload) : tab);

      } else {
        this.$emit('neded-materials', tab);
      }

      if(this.isCurTabMore)
        this.openedMoreTabs = false;
    },

    onChangePage() {
      this.$emit('change-page');
    },

    showMore() {
      this.openedMoreTabs = !this.openedMoreTabs;
    },

    onClickOutsidePosition(e) {
      if(!($(e.target).closest($(this.$refs.more)).length)) {
        this.openedMoreTabs = false;
      }
    },

    getAbbreviation(str) {
      return appHelper.getAbbreviation(str, 4);
    },

    fixScrollAfterOpenLinkInNewTab() {
      this.$nextTick(() => {
        if(!!this.$refs.tabContent)
          setTimeout(() => {
            this.$refs.tabContent.scrollTop = 0;
          }, 1);
      });
    },

    __isFirsTab(checkTab) {
      if(!!this.data.children && !!this.data.children.length)
        return checkTab === this.data.children[0];
      return false;
    },

    __isLastTab(checkTab) {
      if(!!this.data.children && !!this.data.children.length)
        for(let i = 0; i < this.data.children.length; i++) {
          if(i > this.indexLastTab)
            return false;
          if(checkTab === this.data.children[i])
            return i === this.indexLastTab;
        }
      return false;
    },

    __getRouterData(item) {
      return {...item.router};
    },

    __initCurTabAndLoadSpecialData() {
      if(!!this.data.children && !!this.data.children.length) {

        if(this.mode === 'cards') {
          this.curTab = this.data.children[0];

          this.$emit('neded-materials', this.data.children.length > 1 ? this.data.children.slice(0, this.startPreload) : this.data.children[0]);
        }

        if(this.mode === 'list') {
          this.curTab = null;

          this.$emit('neded-materials', this.data.children.slice());
        }

      }
    }
  },

  watch: {
    data: function () {
      if(!!this.data.children && !!this.data.children.length && this.mode === 'list') {
        this.$emit('neded-materials', this.data.children.slice());
      }
    },

    "data.children": function (_new, old) {
      if(!!_new && !!_new.length) {
        if(this.curTab === null)
          this.onSelectPlugin(_new[0]);
        else {
          let index = _.findIndex(_new, ['id', this.curTab.id]);
          if(index < 0)
            this.onSelectPlugin(_new[0]);
          else
            if(!!old && !!old.length) {
              if(old.length !== _new.length)
                this.onSelectPlugin(_new[0]);
              else {
                let change = false;
                for(let i in _new)
                  if(_new[i] !== old[i])
                    change = true;
                if(change && _new[0] !== this.curTab)
                  this.onSelectPlugin(_new[0]);
              }
            }
            else
              if(_new[0] !== this.curTab)
                this.onSelectPlugin(_new[0]);
        }

        if(this.mode === 'list') {
          this.$emit('neded-materials', this.data.children.slice());
        }
      }
    },

    mode() {
      this.__initCurTabAndLoadSpecialData();
    }
  }
}
</script>

<style lang="scss" scoped>
  .card-plugin {
    position: relative;
    border-radius: 5px;
  }

  .name {
    margin-bottom: 5px;
    font-weight: bold;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }

  .tabs-select-wrap {
    position: relative;
  }

  .tabs-select-plugin {
    position: relative;
    list-style: none;
    display: flex;
    height: 50px;
    margin: 0;
    padding: 0;
    z-index: 2;
    background-color: #f7f9fb;

    /*todo-mark связано с шириной табов в css*/
    > li {
      position: relative;
      width: 20%;
    }

    > li > button {
      margin: 1px 0 0;
      border: 1px solid transparent;
      border-bottom: none;
      outline: none;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: calc(100% - 1px);
      font-size: 20px;
      background-color: transparent;
      border-radius: 5px 5px 0 0;
    }

    > li.active > button {
      border-color: #ccc;
      padding: 0;
      background-color: #fff;
      color: #c00;
    }

    > li.active > button:after {
      content: "";
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      border-bottom: 1px solid #fff;
    }

    img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 70%;
      max-height: 70%;
      height: auto;
      width: auto;
    }

    .icon-more {
      position: absolute;
      right: 50%;
      bottom: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #212529;
      transform: translate(50%, 50%);
      transition: all 0.3s ease-in-out;
    }

    li.active .icon-more {
      right: 2px;
      bottom: 2px;
      transform: translate(0, 0) scale(0.7);
    }

    .abbreviation {
      font-size: 16px;
    }
  }

  .tabs-select-more {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    margin: 0;
    padding: 0;
    border: 1px solid #ccc;
    border-right: none;
    border-radius: 5px 0 0 5px;
    overflow: hidden;
    background-color: #f7f9fb;

    .tabs-select-more-item {
      background-color: #fff;
    }

    .tabs-select-more-item button {
      margin: 0;
      border: none;
      outline: none;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 50px;
      height: 50px;
      font-size: 20px;
      background-color: transparent;
    }

    .tabs-select-more-item:nth-child(n + 2) button {
      border-top: 1px solid #ccc;
    }

    img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 70%;
      max-height: 70%;
      height: auto;
      width: auto;
    }

    .full-name {
      font-weight: bold;
    }
  }

  .tabs-name-more {
    position: absolute;
    top: 100%;
    left: 100%;
    margin: 0;
    padding: 0;
    border: 1px solid #ccc;
    border-left: none;
    border-radius: 0 5px 5px 0;
    overflow: hidden;
    background-color: #f7f9fb;

    .tabs-name-more-item {
      background-color: #fff;
    }

    .tabs-name-more-item button {
      margin: 0;
      padding: 0 10px 0 5px;
      border: none;
      outline: none;
      position: relative;
      height: 50px;
      font-size: 20px;
      background-color: transparent;
    }

    .tabs-name-more-item:nth-child(n + 2) button {
      border-top: 1px solid #ccc;
    }
  }

  .tab-content-wrap {
    position: relative;
    height: 164px;
  }

  .tab-content {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    padding: 10px;
    overflow: hidden;
    font-size: 14px;
    line-height: 1.2;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #fff;
    z-index: 1;
  }

  .tab-content:after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 20px;
    background: linear-gradient(to top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
  }

  .tab-content-wrap:hover .tab-content {
    min-height: 100%;
    height: auto;
    overflow: visible;
    box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.5), 2px 0 2px -2px rgba(0, 0, 0, 0.5), -2px 0 2px -2px rgba(0, 0, 0, 0.5);
  }

  .tab-content-wrap:hover .tab-content:after {
    display: none;
  }

  .tab-content-wrap.first-tab-active .tab-content {
    border-top-left-radius: 0;
  }

  .tab-content-wrap.last-tab-active .tab-content {
    border-top-right-radius: 0;
  }

  .not-content {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    font-size: 24px;
    color: #999;
    border-top: 1px solid #ccc;
  }

  .name-content {
    margin-bottom: 3px;
    font-weight: bold;
  }

  .desc {
    margin-bottom: 15px;
  }

  .loader {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(255, 255, 255, 0.5);
    z-index: 1;
  },

  .list {
    font-size: 14px;
    line-height: 1.2;

    .not-content {
      height: 120px;
      border-top: none;
      font-size: 36px;
    }
  }

  .list-plugin {
    position: relative;
    margin-top: 15px;
    margin-bottom: 15px;
    padding: 15px;
    background: #ffffff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  }

  .list-icon {
    margin: 0;
    border: none;
    outline: none;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    font-size: 20px;
    background-color: transparent;

    img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 70%;
      max-height: 70%;
      height: auto;
      width: auto;
    }
  }

  .__list .list-icon {
    display: inline-flex;
    width: 35px;
    height: 35px;

    img {
      max-width: 100%;
      max-height: 100%;
    }
  }

  .list-name {
    margin-left: 5px;
    font-size: 16px;
  }

  .list-name-link {
    font-weight: bold;

    .list-name-link-wrap-ineer {
      margin-bottom: 5px;
      display: flex;
      align-items: center;
    }
  }
</style>

<style lang="scss">
  .card-plugin {
    .more-info-training-material {
      display: flex;
      justify-content: space-between;
      align-items: center;
      .more-icon {
        flex: 0 0 auto;
      }

      .dropdown-menu a {
        display: flex;
        justify-content: space-between;
      }
    }
  }
</style>