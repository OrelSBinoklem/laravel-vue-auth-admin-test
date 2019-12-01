<template lang="pug">


  .more-info(:class="{__cards: mode === 'cards', __list: mode === 'list'}")

    .more-info-section-download-and-author-links
      //Скачать
      .more-info-section.more-info-download
        .more-icon(title="Скачать"): fa(icon="download")
        .row-btn-group.row(v-if="!!curPluginUrl")
          .col-12
            .btn-group
              b-button(variant='outline-primary' size="sm" block :href="curPluginUrl" title="Скачать плагин"): fa(icon="file-archive")
              button.btn.btn-sm.btn-primary.dropdown-toggle.dropdown-toggle-split(type='button' @click="showCollapseDownload = !showCollapseDownload" title="Дополнительный код"): span.sr-only
        template(v-if="mode === 'cards'")
          b-collapse(v-model="showCollapseDownload")
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
        .more-icon(title="Ссылки на плагин" :class="{'exist': !!data.material.meta_data.plugin_site || !!data.material.meta_data.plugin_github || !!data.material.meta_data.plugin_npm || !!data.material.meta_data.plugin_demo}"): fa(icon="link")
        a.btn.btn-sm.btn-outline-primary(v-if="!!data.material.meta_data.plugin_site" :href="data.material.meta_data.plugin_site" title="Сайт плагина" target="_blank"): fa(icon="globe")
        a.btn.btn-sm.btn-outline-primary(v-if="!!data.material.meta_data.plugin_github" :href="data.material.meta_data.plugin_github" title="GitHub" target="_blank"): fa(:icon="['fab', 'github']")
        a.btn.btn-sm.btn-outline-primary(v-if="!!data.material.meta_data.plugin_npm" :href="data.material.meta_data.plugin_npm" title="NPM" target="_blank"): fa(:icon="['fab', 'npm']")
        a.btn.btn-sm.btn-outline-primary(v-if="!!data.material.meta_data.plugin_demo" :href="data.material.meta_data.plugin_demo" title="Демо" target="_blank"): fa(icon="eye")

      .more-info-download-list-editors(v-if="mode === 'list'")
        b-collapse(v-model="showCollapseDownload")
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

    //Фиксы и улучшения плагина
    .more-info-section.more-info-fix-extend-plugin
      .more-icon(title="Фиксы и улучшения плагина"): fa(icon="paperclip")
      .link-columns
        .link-row(v-if="!!curSubItems" v-for="item in curSubItems")
          router-link(v-if='item.is_router', :to='__getRouterData(item)', active-class='active'): span(@click="onChangePage") {{ item.name }}
          a(v-else='', :href='item.path' @click="onChangePage") {{ item.name }}

    //Обучающий материал
    .more-info-section.more-info-training-material
      .more-icon(title="Обучающие материалы"): fa(icon="graduation-cap")
      b-dropdown(
        v-if="!!data.material.meta_data.teaching && !!data.material.meta_data.teaching.length"
        variant="outline-primary"
        size="sm"
        text='Обучающие материалы'
      )
        b-dropdown-item(v-for="item in data.material.meta_data.teaching" :href="item.link" target="_blank" :key="item.title + '-' + item.link")
          span {{item.title}}&nbsp;
          span: fa(:icon="getIconFromUrl(item.link)")

    //Категории
    .more-info-section.more-info-cat
      .more-icon(title="Категории"): fa(icon="folder")
      b-badge(v-for="cat in data.material.categories" variant="default" :key="'cat:' + cat.id") {{cat.title}}

    //Тэги
    //todo-mark отключено пока незделаю характеристики для контента
    //.more-info-section.more-info-tag
      .more-icon(title="Тэги"): fa(icon="tag")
      b-badge(v-for="tag in data.material.tags" variant="primary" :key="'tag:' + tag.id") {{tag.title}}


</template>

<script>

import $ from 'jquery'
import _ from 'lodash'

export default {
  name: 'MoreInfo',

  components: {

  },

  props: {
    mode: {validator: function (value) {return ['cards', 'list'].indexOf(value) !== -1}, required: true},
    data: {type: Object, required: true}
  },

  data() {
    return {
      showCollapseDownload: false
    }
  },

  beforeMount() {

  },

  mounted () {

  },

  beforeDestroy() {

  },

  computed: {
    widgetCopyCode() {
      if(_.hasIn(this, 'data.material.meta_data.positions.use_code.widgets[0]'))
        return this.data.material.meta_data.positions.use_code.widgets[0];
      else
        return [];
    },

    curPluginUrl() {
      if(_.hasIn(this, 'data.material.meta_data.plugin_file') && !!this.data.material.meta_data.plugin_file)
        return '/storage' + this.data.material.meta_data.plugin_file;
      else
        return null;
    },

    curSubItems() {
      if(_.hasIn(this, 'data.children') && !!this.data.children.length)
        return this.data.children;
      else
        return null;
    },
  },

  methods: {
    onChangePage() {
      this.$emit('change-page');
    },

    getPriorityEditor(variant_or_group, editors) {
      let priority = this.$store.getters['interface/priorityCopyTypeCode']
      if(variant_or_group in priority) {
        let concreteType = priority[variant_or_group]
        let result = _.find(editors, ['props.variant', concreteType]);
        return !!result ? result : editors[0]
      } else {
        return editors[0]
      }
    },

    onCopy(heading) {
      this.$eventHub.$emit('open-modal', {
        type: 'success',
        title: heading,
        message: 'Скопировано!'
      });
    },

    onErrorCopy() {
      this.$eventHub.$emit('open-modal', {
        type: 'error',
        title: null,
        message: 'Error Copy!'
      });
    },

    getIconFromUrl(url) {
      return appHelper.getFaIconServiceFromUrl(url);
    },

    __getRouterData(item) {
      return {...item.router};
    },
  },

  watch: {

  }
}
</script>

<style lang="scss" scoped>
  .more-info-section {
    .more-icon {
      margin-right: 5px;
      margin-bottom: 5px;
      position: relative;
      display: inline-block;
      z-index: 1;
    }
  }

  .more-info-section:nth-child(n + 2) {
    margin-top: 5px;
  }

  .__list {
    .more-info-section-download-and-author-links {
      margin: 0 -15px;
      display: flex;
      flex-wrap: wrap;
    }
  }

  .more-info-download {
    .row {
      padding-top: 2px;
      padding-bottom: 2px;
    }

    .heading {
      margin-top: 6px;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
      font-size: 14px;
    }

    .row-btn-group {
      margin-top: -31px;
      text-align: right;
    }
  }

  .__list {
    .more-info-download {
      padding: 0 15px;
      width: 150px;
      flex: 0 0 auto;

      .more-icon {
        margin-top: 8px;
      }
    }
  }

  .more-info-download-list-editors {
    padding: 0 15px;
    width: 100%;

    .row {
      padding-top: 2px;
      padding-bottom: 2px;
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
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;

    .exist.more-icon {
      margin-top: 11px;
    }

    .btn {
      margin: 0.25rem;
      width: 34px;
    }
  }

  .__list {
    .more-info-author-links {
      margin-top: -4px;
      margin-left: auto;
      padding: 0 15px;
    }
  }

  .more-info-fix-extend-plugin {
    .link-row {
      width: 100%;
      display: inline-block;
    }
  }

  .__list .more-info-fix-extend-plugin {
    .link-columns {
      column-count: 2;
      column-gap: 15px;
    }
  }

  .more-info-cat,
  .more-info-tag {
    .more-icon {
      margin-bottom: 0;
    }

    .badge {
      margin: 0 3px;
    }

    .badge:first-child {
      margin-left: 25px;
    }
  }
</style>

<style lang="scss">

</style>