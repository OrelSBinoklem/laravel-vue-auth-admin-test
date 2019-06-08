<template lang="pug">
  .position(@click="onClick" :class="{active: current === data}")
    .name {{data.data.name}}
      span.error-count(v-if="__errorsCount()"): fa(icon='exclamation-triangle')
      span.rules
        b-card
          template(v-for="(rule, iRule) in rules")
            br(v-if="iRule != 0")
            span.rule
              span.rule-name(v-if="'name' in rule") name: {{rule.name + ''}}
              span.rule-count(v-if="'count' in rule") {{', '}}
                span.rule-count-text(:class="{error: rule.errorCount}") count: {{rule.count}}
              span.rule-props(v-if="'props' in rule")
                span.rule-prop(v-for="(prop, propName) in rule.props")
                  span.rule-prop-name {{propName + ': '}}
                  span.rule-prop-value {{prop + ''}}
              span.rule-not(v-if="'not' in rule") {{', '}}
                span.rule-not-text {{'NOT: '}}
                span.rule-name(v-if="'name' in rule.not") name: {{rule.not.name + ''}}
                span.rule-props(v-if="'props' in rule.not")
                  span.rule-prop(v-for="(prop, propName) in rule.not.props")
                    span.rule-prop-name {{propName + ': '}}
                    span.rule-prop-value {{prop + ''}}
    .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}`) }")
    has-error(:form='form', :field='`${prefixDataForm}`')
    draggable(v-model="data.widgets" handle=".widget")
      template(v-if="data.widgets" v-for="(widget, index) in data.widgets")
        .widget-container
          AdminWidget(:edit="edit" :form="form" :data="widget" :positionData="data" :prefixDataForm="prefixDataForm + '.widgets.' + index")
          b-button.btn-widget-delete(variant='outline-danger' @click='onDeleteWidget(index)'): fa(icon='times', size='lg')
    b-button.btn-widget-clone(v-if="'widgets' in data && data.widgets.length" block variant='outline-success' @click='onCloneWidget'): fa(:icon="['far', 'clone']")
</template>

<script>
  import Form from 'vform'
  import $ from 'jquery'
  import _ from 'lodash'
  import draggable from 'vuedraggable'
  import { mapGetters } from 'vuex'
  import Validator from 'validatorjs'
  import {types as widgetTypes} from './types'
  import AdminWidget from './AdminWidget'

  export default {
    name: "AdminPosition",

    components: {
      AdminWidget,

      draggable
    },

    props: {
      edit: {
        type: Boolean,
        required: true
      },

      form: {
        type: Form,
        required: true
      },

      data: {
        type: Object,
        required: true
      },

      prefixDataForm: {
        type: String,
        required: true
      }
    },

    beforeMount() {
      Validator.useLang(this.$store.getters['lang/locale']);

      if(this.types === null) {
        this.$store.dispatch('content-widgets/setWidgetsTypes', widgetTypes)
      }
    },

    data: () => ({
      rerenderErrorsCount: false
    }),

    computed: {
      ...mapGetters({
        current: 'content-widgets/selected',
        types: 'content-widgets/widgetsTypes'
      }),

      rules() {
        return this.data.rules
      },

      errorsCount() {
        if(this.rerenderErrorsCount) {
          return this.hasErrorsCount()
        } else {
          return this.hasErrorsCount()
        }
      }
    },

    methods: {
      onClick() {
        this.$store.dispatch('content-widgets/setSelectPosition', this.data)
      },

      __errorsCount() {
        let globalError = false
        for(let iRule in this.rules) {
          let hasCount = this.__checkCount(this.rules[iRule], this.data.widgets)
          this.rules[iRule].errorCount = !hasCount
          if(this.rules[iRule].errorCount) {
            globalError = true
          }
        }

        return globalError
      },

      __checkCount(rule, widgets) {
        if('count' in rule && rule.count != '*') {
          //Считаем количество соответствующих виджетов
          let count = 0;

          let rules = {};
          if('name' in rule){rules.name = rule.name;}
          if('props' in rule) {
            for(let propName in rule.props) {
              rules['props.' . propName] = rule.props[propName];
            }
          }
          let rules_not = {};
          if('not' in rule) {
            if('name' in rule.not){rules_not.name = rule.not.name}
            if('props' in rule.not) {
              for(let propName in rule.not.props) {
                rules_not['props.' + propName] = rule.not.props[propName];
              }
            }
          }

          for(let key in widgets) {
            if(!(new Validator(widgets[key], rules).fails()) && (!_.keysIn(rules_not).length || (new Validator(widgets[key], rules_not).fails()))) {
              count++;
            }
          }
          //\Считаем количество соответствующих виджетов

          //Варианты шаблонов count
          //'*' - сколько угодно
          //n - точное число
          //n+ - число и больше
          //n-m - промежуток

          /*if($rule_pos['count'] == '*') {//переместил вверх
              return true;
          }*/
          if(/^[1-9]\d*$/i.test(rule.count + '')) {
            return count === parseInt(rule.count);
          } else if(/^[1-9]\d*\+$/i.test(rule.count + '')) {
            return count >= parseInt(replace(/\D/, '', rule.count + ''));
          } else if(/^(\d+)\-([1-9]\d*)$/i.test(rule.count + '')) {
            let match = /^(\d+)\-([1-9]\d*)$/i.exec(rule.count + '')
            return count >= parseInt(match[1]) && count <= parseInt(match[2]);
          }
        } else {
          return true;
        }
      },

      hasErrorsCount() {
        for(let iRule in this.rules) {
          if('errorCount' in this.rules[iRule] && this.rules[iRule].errorCount) {
            return true
          }
        }
        return false
      },

      onDeleteWidget(index) {
        this.data.widgets.splice(index, 1)
      },

      onCloneWidget() {
        this.data.widgets.push(
          $.extend(true, {}, this.data.widgets[this.data.widgets.length - 1])
        )
      }
    },

    watch: {

    }
  }
</script>

<style lang="sass" scoped>
  .position
    padding: 5px
    min-width: 30px
    min-height: 15px
    outline: 1px dashed red
    outline-offset: -1px
    &.active
      outline-width: 3px
      outline-style: solid
      outline-offset: -2px
    ~ .position
      margin-top: 5px

  .name
    position: relative
    margin: 0 15px 8px
    display: inline-block
    font-size: 12px
    font-weight: bold

  .error-count
    position: absolute
    left: calc(100% + 3px)
    top: 0
    color: red

  .rules
    display: none
    position: absolute
    top: 100%
    left: 0
    z-index: 1

  .name:hover .rules
    display: block

  .rule
    display: inline-block
    padding-left: 3px
    padding-right: 3px
    font-size: 12px
    font-weight: bold
    white-space: nowrap
    &-count-text.error
      color: red

  .widget-container
    position: relative
    ~ .widget-container
      margin-top: 5px

  .btn-widget-delete
    display: none
    position: absolute
    top: 0
    right: 0

  .widget-container:hover .btn-widget-delete
    display: block

  .btn-widget-clone
    margin-top: 5px
</style>