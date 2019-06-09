<template lang="pug">
  .widget
    .name {{name}}
      span.error-widget(v-if="!__widgetMatchesPosition()"): fa(icon='exclamation-triangle')
    .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}`) }")
    has-error(:form='form', :field='`${prefixDataForm}`')
    component(v-bind:is="data.name" v-bind="data.props" :edit="edit" :form="form" :data="data" :prefixDataForm="prefixDataForm")
      template(v-if="data.positions" v-for="(position, name) in data.positions" :slot="name")
        AdminPosition(:edit="edit" :form="form" :data="position" :prefixDataForm="prefixDataForm + '.positions.' + name")
</template>

<script>
  import Form from 'vform'
  import _ from 'lodash'
  import { mapGetters } from 'vuex'
  import Validator from 'validatorjs'
  import AdminPosition from './AdminPosition'
  import alert from './alert/Admin'

  export default {
    name: "AdminWidget",

    components: {
      AdminPosition,
      alert
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

      positionData: {
        type: Object,
        required: true
      },

      prefixDataForm: {
        type: String,
        required: true
      }
    },

    beforeMount() {

    },

    data: () => ({

    }),

    computed: {
      name() {
        return this.typesObj !== null && this.data.name in this.typesObj ? this.typesObj[this.data.name].name : 'slug:' + this.data.name
      },

      ...mapGetters({
        typesObj: 'content-widgets/widgetsTypesObject'
      })
    },

    methods: {
      __widgetMatchesPosition() {
        for(let posName in this.positionData.rules) {
          let rule = this.positionData.rules[posName]

          let rules = {};
          if('name' in rule){rules.name = rule.name}
          if('props' in rule) {
            for(let propName in rule.props) {
              rules['props.' + propName] = rule.props[propName];
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

          if(!(new Validator(this.data, rules).fails()) && (!_.keysIn(rules_not).length || (new Validator(this.data, rules_not).fails()))) {
            return true;
          }
        }

        return false;
      }
    },

    watch: {

    }
  }
</script>

<style lang="sass" scoped>
  .widget
    padding: 5px
    min-width: 30px
    min-height: 15px
    outline: 1px dashed #000
    outline-offset: -1px
    &.active
      outline-width: 3px
      outline-style: solid
      outline-offset: -2px

  .name
    position: relative
    margin: 5px 15px 5px
    display: inline-block
    font-size: 12px
    font-weight: bold

  .error-widget
    position: absolute
    left: calc(100% + 3px)
    top: 0
    color: red
</style>