<template lang="pug">


  .card-plugin

    .name(:title="data.name") {{data.name}}

    .tabs-select-wrap
      ul.tabs-select-plugin
        li(v-for='tab in visibleTabs' :class='{active: tab === curTab}')
          button(@click='onSelectPlugin(tab)')
            img(v-if="!!tab.icon" :src="'/storage' + tab.icon")
            .abbreviation(v-else) {{getAbbreviation(tab.name)}}
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

    .tab-content-wrap(:class="{'first-tab-active': __isFirsTab(curTab), 'last-tab-active': __isLastTab(curTab) || isCurTabMore}")
      .tab-content(v-if="!!data.children && !!data.children.length")
        .name-content
          router-link(v-if='curTab.is_router', :to='__getRouterData(curTab)', active-class='active'): span(@click="onChangePage") {{ curTab.name }}
          a(v-else='', :href='curTab.path' @click="onChangePage") {{ curTab.name }}
        template(v-if="!!curTab && !!curTab.material")
          .desc(v-if="!selMoreInfo") {{curTab.material.description_short}}
          .more-info(v-else)

            //Скачать
            .more-info-section.more-info-download
              .more-icon(title="Скачать"): fa(icon="download")
              .row(v-if="!!curPluginUrl")
                .col-8: h6.heading(title="Скачать плагин") Скачать плагин
                .col-4.pl-0
                  b-button(
                    variant='primary'
                    size="sm"
                    block
                    :href="curPluginUrl"
                  )
                    fa(icon="file-archive")
              template(v-if="'props' in widgetCopyCode && 'editors' in widgetCopyCode.props")
                .row(v-for="(editor, index) in widgetCopyCode.props.editors")
                  .col-8: h6.heading(:title="editor.heading") {{ editor.heading }}
                  .col-4.pl-0
                    b-button(
                      variant='outline-primary'
                      size="sm"
                      block
                      v-clipboard:copy='getPriorityEditor(editor.variant_or_group, widgetCopyCode.positions["editor" + index].widgets).props.code'
                      v-clipboard:success="() => onCopy(editor.heading)"
                      v-clipboard:error="onErrorCopy"
                    )
                      | {{getPriorityEditor(editor.variant_or_group, widgetCopyCode.positions["editor" + index].widgets).props.variant}}&nbsp;
                      fa(:icon="['far', 'copy']")

            //Ссылки автора
            .more-info-section.more-info-author-links
              .more-icon(title="Ссылки на плагин"): fa(icon="link")
              a.btn.btn-outline-primary.m-1(v-if="!!curTab.material.meta_data.plugin_site" :href="curTab.material.meta_data.plugin_site" title="Сайт плагина" target="_blank"): fa(icon="globe")
              a.btn.btn-outline-primary.m-1(v-if="!!curTab.material.meta_data.plugin_github" :href="curTab.material.meta_data.plugin_github" title="GitHub" target="_blank"): fa(:icon="['fab', 'github']")
              a.btn.btn-outline-primary.m-1(v-if="!!curTab.material.meta_data.plugin_npm" :href="curTab.material.meta_data.plugin_npm" title="NPM" target="_blank"): fa(:icon="['fab', 'npm']")
              a.btn.btn-outline-primary.m-1(v-if="!!curTab.material.meta_data.plugin_demo" :href="curTab.material.meta_data.plugin_demo" title="Демо" target="_blank"): fa(icon="eye")

            //Обучающий материал
            .more-info-section.more-info-training-material
              .more-icon(title="Обучающие материалы"): fa(icon="graduation-cap")

            //Категории
            .more-info-section.more-info-cat
              .more-icon(title="Категории"): fa(icon="folder")
              .more-info-cat-row
                b-badge(v-for="cat in curTab.material.categories" variant="primary" :key="'cat:' + cat.id") {{cat.title}}

            //Тэги
            .more-info-section.more-info-tag
              .more-icon(title="Тэги"): fa(icon="tag")
              .more-info-tag-row
                b-badge(v-for="tag in curTab.material.tags" variant="primary" :key="'tag:' + tag.id") {{tag.title}}

        .tab-content-desc(:class="{active: !selMoreInfo}" @click="selMoreInfo = false" title="Краткое описание"): fa(icon="file-alt")
        .tab-content-more(:class="{active: selMoreInfo}" @click="selMoreInfo = true" title="Дополнительные данные"): fa(icon="boxes")
      .not-content(v-else) пусто


</template>

<script>

import $ from 'jquery'
import _ from 'lodash'
import Taxonomy from "../../../pages/admin/taxonomy";

export default {
  name: 'CardPlugin',

  components: {
    Taxonomy

  },

  props: {
    data: {type: Object, required: true},
    maxTabsLinkRow: {type: Number, default: 5},
  },

  data() {
    return {
      curTab: null,
      openedMoreTabs: false,
      selMoreInfo: false
    }
  },

  beforeMount() {
    if(!!this.data.children && !!this.data.children.length) {
      this.curTab = this.data.children[0];
    }

    document.body.addEventListener('click', this.onClickOutsidePosition);
  },

  beforeDestroy() {
    document.body.removeEventListener('click', this.onClickOutsidePosition);
  },

  mounted () {

  },

  computed: {
    indexLastTab() {
      //todo-mark связано с шириной табов в css
      return this.maxTabsLinkRow - 1;
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

    widgetCopyCode() {
      if(_.hasIn(this, 'curTab.material.meta_data.positions.use_code.widgets[0]'))
        return this.curTab.material.meta_data.positions.use_code.widgets[0];
      else
        return [];
    },

    curPluginUrl() {
      if(_.hasIn(this, 'curTab.material.meta_data.plugin_file') && !!this.curTab.material.meta_data.plugin_file)
        return '/storage' + this.curTab.material.meta_data.plugin_file;
      else
        return null;

    }
  },

  methods: {
    onSelectPlugin(tab) {
      this.curTab = tab;

      if(this.isCurTabMore)
        this.openedMoreTabs = false;
    },

    onChangePage() {
      this.$emit('change-page');
    },

    showMore() {
      this.openedMoreTabs = !this.openedMoreTabs;
    },

    getPriorityEditor(variant_or_group, editors) {
      let priority = this.$store.getters['interface/priorityCopyTypeCode']
      if(variant_or_group in priority) {
        let concreteType = priority[variant_or_group]
        let result = _.find(editors, ['props.variant', concreteType]);
        return result ? result : editors[0]
      } else {
        return editors[0]
      }
    },

    onClickOutsidePosition(e) {
      if(!($(e.target).closest($(this.$refs.more)).length)) {
        this.openedMoreTabs = false;
      }
    },

    onCopy(heading) {
      this.$eventHub.$emit('open-modal', {
        type: 'success',
        title: heading,
        message: 'Copied!'
      });
    },

    onErrorCopy() {
      this.$eventHub.$emit('open-modal', {
        type: 'error',
        title: null,
        message: 'Error Copy!'
      });
    },

    getAbbreviation(str) {
      return appHelper.getAbbreviation(str, 4);
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
    }
  },

  watch: {

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

  .tab-content-more,
  .tab-content-desc {
    position: absolute;
    top: 2px;
    right: 2px;
    width: 26px;
    height: 26px;
    display: flex;
    justify-content: center;
    align-items: center;
    /*background-color: #f7f9fb;*/
    background-color: #E6E8EA;
    border-radius: 5px;
    color: #999;
    cursor: pointer;
  }

  .tab-content-more:hover,
  .tab-content-desc:hover {
    color: #212529;
  }

  .tab-content-more.active,
  .tab-content-desc.active {
    color: #212529;
    background-color: #fff;
  }

  .tab-content-desc {
    right: 34px;
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

  .more-info-section {
    .more-icon {
      margin-bottom: 5px;
    }
  }

  .more-info-section:nth-child(n + 2) {
    margin-top: 5px;
  }

  .more-info-download {
    .row {
      margin-bottom: 3px;
    }

    .heading {
      margin-top: 6px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
      font-size: 14px;
    }
  }

  .more-info-author-links {

  }

  .more-info-cat-row,
  .more-info-tag-row {
    margin-left: -3px;
    margin-right: -3px;

    .badge {
      margin-left: 3px;
      margin-right: 3px;
    }
  }
</style>

<style lang="scss">

</style>