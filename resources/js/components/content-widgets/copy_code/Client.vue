<template lang="pug">
  div(v-if="__countPositions(positions)" class="copy-code")
    //type-row
    .type-row(v-if="type_visible === 'row'")
      .row.type-row__head: .col.d-flex.align-items-stretch(v-for="(editor, index) in editors"): .row.justify-content-between.align-items-end.type-row__head-row-inner-col
        .col: h6.type-row__heading {{ editor.heading }}
        .col-auto: b-button(
          variant='outline-primary'
          v-clipboard:copy='getPriorityEditor(editor.variant_or_group, positions["editor" + index].widgets).props.code'
          v-clipboard:success="() => onCopy(editor.heading)" v-clipboard:error="onErrorCopy")
          | {{getPriorityEditor(editor.variant_or_group, positions["editor" + index].widgets).props.variant}}&nbsp;
          fa(:icon="['far', 'copy']")
      .row.type-row__editors
        .col(v-for="(editor, index) in editors" @click="onClickEditor(editor)" :class="{'active': current === editor}")
          OneRenderEditor(
            :variant="getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.variant"
            :min_lines="linesTypeRow" :max_lines="linesTypeRow"
            :code="getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.code")
    //type-vert-tabs
    .type-vert-tabs(v-if="type_visible === 'vertical_tabs'")
      .row
        .col-3
          b-button(
            block
            variant='outline-primary'
            v-clipboard:copy='getPriorityEditor(editors[currentTabIndex].variant_or_group, positions["editor" + currentTabIndex].widgets).props.code'
            v-clipboard:success="() => onCopy(editors[currentTabIndex].heading)" v-clipboard:error="onErrorCopy") Copy!
          ul.list-group
            li.list-group-item.d-flex.justify-content-between.align-items-center(
              v-for="(editor, index) in editors"
              :class="{active: index == currentTabIndex}"
              @click="onSelectTab(index)")
              | {{ editor.heading }}
              span.badge.badge-light.badge-pill {{ getPriorityEditor(editor.variant_or_group, positions["editor" + index].widgets).props.variant }}
        .col-9(ref="vert_tabs_editor")
          OneRenderEditor(
            :variant="getPriorityEditor(editors[currentTabIndex].variant_or_group, positions[\"editor\" + currentTabIndex].widgets).props.variant"
            :min_lines="linesTypeVertTabs" :max_lines="linesTypeVertTabs"
            :code="getPriorityEditor(editors[currentTabIndex].variant_or_group, positions[\"editor\" + currentTabIndex].widgets).props.code")
    //type-casual
    .type-casual(v-if="type_visible === 'casual'")
      .row(v-for="(editor, index) in editors")
        .col-12.type-casual__head: .row.justify-content-between.align-items-end
          .col: h6.type-casual__heading {{ editor.heading }}
          .col-auto: b-button(
            variant='outline-primary'
            v-clipboard:copy='getPriorityEditor(editor.variant_or_group, positions["editor" + index].widgets).props.code'
            v-clipboard:success="() => onCopy(editor.heading)" v-clipboard:error="onErrorCopy")
            | {{getPriorityEditor(editor.variant_or_group, positions["editor" + index].widgets).props.variant}}&nbsp;
            fa(:icon="['far', 'copy']")
        .col-12.type-casual__body(@click="onClickEditor(editor)")
          OneRenderEditor(
            :variant="getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.variant"
            :min_lines="getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.min_lines ? getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.min_lines : min_lines"
            :max_lines="getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.max_lines ? getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.max_lines : max_lines"
            :code="getPriorityEditor(editor.variant_or_group, positions[\"editor\" + index].widgets).props.code")
</template>

<script>
  import $ from 'jquery'
  import Vue from 'vue'
  import _ from 'lodash'
  import { mapGetters } from 'vuex'
  import OneRenderEditor from './OneRenderEditor'
  import {mixinClient} from '../mixinClient'

  export default {
    name: "Client",

    mixins: [mixinClient],

    components: {
      OneRenderEditor
    },

    props: {
      type_visible: {
        type: String,
        required: true
      },

      getter_store_priority_type_code: {
        type: String,
        required: true
      },

      count_editors: {
        required: true
      },

      min_lines: {
        required: true
      },

      max_lines: {
        required: true
      },

      editors: {
        type: Array,
        required: true
      },

      positions: {
        required: true
      }
    },

    data: () => ({
      //todo-orel Добавить изменение размера шрифта
      fontSize: 12,
      lineHeight: 14,

      currentTabIndex: 0,

      linesTypeVertTabs: 0
    }),

    beforeMount() {
      document.body.addEventListener('click', this.onClickOutsidePosition)
    },

    beforeDestroy() {
      document.body.removeEventListener('click', this.onClickOutsidePosition)
    },

    updated() {
      if(this.type_visible === 'vertical_tabs') {
        this.linesTypeVertTabs = this.__setLinesTypeVertTabs()
      }
    },

    mounted () {
      if(this.type_visible === 'vertical_tabs') {
        this.linesTypeVertTabs = this.__setLinesTypeVertTabs()
      }
    },

    computed: {
      ...mapGetters({
        current: 'content-widgets/selectedCopyCode'
      }),

      linesTypeRow() {
        let maxCount = 0
        for(let index in this.editors) {
          let editor = this.editors[index]
          let text = this.getPriorityEditor(editor.variant_or_group, this.positions["editor" + index].widgets).props.code
          let count = this.__countLine(text)
          if(maxCount < count) {
            maxCount = count
          }
        }

        let lines = maxCount + 1

        if(lines < parseInt(this.min_lines)) {
          lines = parseInt(this.min_lines)
        }

        if(lines > parseInt(this.max_lines)) {
          lines = parseInt(this.max_lines)
        }

        return lines
      }
    },

    methods: {
      onClickEditor(editor) {
        this.$store.dispatch('content-widgets/setSelectCopyCode', editor)
      },

      getPriorityEditor(variant_or_group, editors) {
        let priority = this.$store.getters[this.getter_store_priority_type_code]
        if(variant_or_group in priority) {
          let concreteType = priority[variant_or_group]
          let result = _.find(editors, ['props.variant', concreteType]);
          return result ? result : editors[0]
        } else {
          return editors[0]
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

      onClickOutsidePosition(e) {
        if (!($(e.target).closest('.copy-code').length)) {
          this.$store.dispatch('content-widgets/setSelectCopyCode', null)
        }
      },

      onSelectTab(i) {
        this.currentTabIndex = i
      },

      __countPositions(obj) {
        return _.keysIn(obj).length
      },

      __countLine(text) {
        let lines = text.split("\n");
        let count = 0;
        for (let i = 0; i < lines.length - 1; i++) {
          if (lines[i].trim() != "" && lines[i].trim() !== null) {
            count++;
          }
        }
        return count;
      },

      __setLinesTypeVertTabs() {
        let maxCount = 0
        for(let index in this.editors) {
          let editor = this.editors[index]
          let text = this.getPriorityEditor(editor.variant_or_group, this.positions["editor" + index].widgets).props.code
          let count = this.__countLine(text)
          if(maxCount < count) {
            maxCount = count
          }
        }

        let lines = maxCount + 1

        if(lines < parseInt(this.min_lines)) {
          lines = parseInt(this.min_lines)
        }

        if(lines > parseInt(this.max_lines)) {
          lines = parseInt(this.max_lines)
        }

        if($(this.$refs.vert_tabs_editor).height() > (lines * this.lineHeight) + 1) {
          return Math.floor(($(this.$refs.vert_tabs_editor).height() - 1) / this.lineHeight)
        }

        return lines
      }
    },

    watch: {

    }
  }
</script>

<style lang="sass" scoped>
.type-row
  &__head
    position: relative
  &__head:after
    content: ''
    position: absolute
    left: 15px
    right: 15px
    bottom: 0
    border-bottom: 1px solid #999
  &__head > .col
    padding: 0 15px 15px
  &__head > .col:nth-child(n + 2)
    border-left: 1px solid #999
  &__heading
    margin-top: 9px
  &__editors .col
    padding: 15px
    transition: flex-grow 0.2s ease-in-out
  &__editors > .col:nth-child(n + 2)
    border-left: 1px solid #999
  &__editors .col.active
    flex-grow: 2
  &__head-row-inner-col
    flex-grow: 1
    flex-basis: 0

.type-vert-tabs
  .list-group-item
    cursor: pointer

.type-casual
  > .row:nth-child(n + 2)
    margin-top: 30px
  &__head
    position: relative
    padding-bottom: 15px
  &__head:after
    content: ''
    position: absolute
    left: 15px
    right: 15px
    bottom: 0
    border-bottom: 1px solid #999
  &__heading
    margin-top: 9px
  &__body
    padding-top: 15px
</style>