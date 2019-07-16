<template lang="pug">
  .col-12
    // Material
    .form-group.row
      .col-12
        b-form-select(v-model='data.props.type_visible', :options='typesVisibleOptions')
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.type_visible`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.type_visible`')
      .col-12.mt-3
        b-form-input(v-model='data.props.getter_store_priority_type_code' placeholder="Getter из Store с приоритетами типов кода")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.getter_store_priority_type_code`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.getter_store_priority_type_code`')
      .col-12.mt-3
        b-form-input(v-model='data.props.count_editors' placeholder="Количество редакторов")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.count_editors`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.count_editors`')
      .col-6.mt-3
        b-form-input(v-model='data.props.min_lines' placeholder="мин. строк глобально")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.min_lines`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.min_lines`')
      .col-6.mt-3
        b-form-input(v-model='data.props.max_lines' placeholder="макс. строк глобально")
        .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.max_lines`) }")
        has-error(:form='form', :field='`${prefixDataForm}.props.max_lines`')
      template(v-for="(editor, index) in data.props.editors")
        .col-6.mt-3
          b-form-input(v-model='editor.heading' placeholder="Заголовок")
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.editors.${index}.heading`) }")
          has-error(:form='form', :field='`${prefixDataForm}.props.editors.${index}.heading`')
        .col-6.mt-3
          b-form-select(v-model='editor.variant_or_group', :options='variantAndGroupsOptions')
          .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.editors.${index}.variant_or_group`) }")
          has-error(:form='form', :field='`${prefixDataForm}.props.editors.${index}.variant_or_group`')
</template>

<script>
  import Vue from 'vue'
  import {mixinAdmin} from '../mixinAdmin'

  export default {
    name: "Admin",

    mixins: [mixinAdmin],

    components: {
      editor: require('vue2-ace-editor')
    },

    props: {

    },

    beforeMount() {
      //todo-orel Зделать функцию задания параметров по умолчанию - чтоб всё это сократить
      if(!('props' in this.data)) {
        Vue.set(this.data, 'props', {});
        Vue.set(this.data.props, 'type_visible', null);
        Vue.set(this.data.props, 'getter_store_priority_type_code', 'interface/priorityCopyTypeCode');
        Vue.set(this.data.props, 'count_editors', 1);
        Vue.set(this.data.props, 'min_lines', 10);
        Vue.set(this.data.props, 'max_lines', 10);
        Vue.set(this.data.props, 'editors', [{heading: 'Редактор 1', variant_or_group: 'html'}]);
      } else {
        if(!('type_visible' in this.data.props)) {
          this.data.props.type_visible = null
        }
        if(!('getter_store_priority_type_code' in this.data.props)) {
          this.data.props.getter_store_priority_type_code = 'interface/priorityCopyTypeCode'
        }
        if(!('count_editors' in this.data.props)) {
          this.data.props.count_editors = 1
        }
        if(!('min_lines' in this.data.props)) {
          this.data.props.min_lines = 10
        }
        if(!('max_lines' in this.data.props)) {
          this.data.props.max_lines = 10
        }
        if(!('editors' in this.data.props)) {
          this.data.props.editors = [{heading: 'Редактор 1', variant_or_group: 'html'}]
        }
      }
    },

    data: () => ({
      typesVisibleOptions: [
        { value: null, text: 'Выберите вариант расположения редакторов' },
        { value: 'row', text: 'В одну строку' },
        { value: 'vertical_tabs', text: 'Вертикальные табы' },
        { value: 'casual', text: 'Обычными блоками' }
      ],

      variantAndGroupsOptions: [
        { value: null, text: 'Выберите язык или группу' },


        { value: 'layouts', text: 'Разметка' },//jade, html
        { value: 'styles', text: 'Стили' },//css, sass, scss, less, stylus
        { value: 'js', text: 'Вариант Javascript' },//javascript, typescript, coffee
        { value: 'data', text: 'Данные' },//json, yaml, xml


        { value: 'jade', text: 'jade' },
        { value: 'html', text: 'html' },

        { value: 'svg', text: 'svg' },

        { value: 'css', text: 'css' },
        { value: 'sass', text: 'sass' },
        { value: 'scss', text: 'scss' },
        { value: 'less', text: 'less' },
        { value: 'stylus', text: 'stylus' },

        { value: 'javascript', text: 'javascript' },
        { value: 'typescript', text: 'typescript' },
        { value: 'coffee', text: 'coffee' },

        { value: 'json', text: 'json' },
        { value: 'yaml', text: 'yaml' },
        { value: 'xml', text: 'xml' },

        { value: 'php', text: 'php' }
      ]
    }),

    computed: {
      positions() {
        let result = {}

        this.__normalizeArrEditors()

        try {
          for(let i = 0; i < parseInt(this.data.props.count_editors); i++) {
            let editor = this.data.props.editors[i]

            result['editor' + i] = {
              data: {
                name: editor.heading
              },
              rules: [
                {
                  name: /^code_editor$/gmi,
                  count: '1-5',
                  props: {
                    variant: this.__getRegexVariablesCode(editor.variant_or_group)
                  }
                }
              ],
              widgets: [{
                name: 'code_editor',
                props: {
                  variant: 'html',
                  min_lines: this.data.props.min_lines,
                  max_lines: this.data.props.max_lines,
                  code: ''
                }
              }]
            }
          }

          return result
        } catch (e) {

        }
      }
    },

    methods: {
      __normalizeArrEditors() {
        let count_editors = this.data.props.count_editors;
        try {
          if(this.data.props.editors.length > parseInt(count_editors)) {
            this.data.props.editors.splice(count_editors, this.data.props.editors.length - parseInt(count_editors))
          } else if(this.data.props.editors.length < parseInt(count_editors)) {
            for(let i = this.data.props.editors.length; i < count_editors; i++) {
              this.data.props.editors.push({heading: 'Редактор ' + (i + 1), variant_or_group: 'html'});
            }
          }
        } catch (e) {

        }
      },

      __getRegexVariablesCode(variant_or_group) {
        if(variant_or_group !== null) {
          if(/^layouts|styles|js|data$/im.test(variant_or_group)) {
            switch(variant_or_group) {
              case 'layouts':
                return ['in:jade,html']
              case 'styles':
                return ['in:css,sass,scss,less,stylus']
              case 'js':
                return ['in:javascript,typescript,coffee']
              case 'data':
                return ['in:json,yaml,xml']
            }
          } else {
            return ['regex:/^' + variant_or_group + '$/im']
          }
        } else {
          return ['regex:/./im']
        }
      }
    },

    watch: {
      'positions': function (positions, oldValue) {
        if(this.data) {

          if(!('positions' in this.data)) {this.data.positions = {}}

          for(let key in positions) {
            if(!(key in this.data.positions)){
              this.data.positions[key] = {}
            }
            if(!('data' in this.data.positions[key])){
              this.data.positions[key].data = {}
            }

            this.data.positions[key].data.name = positions[key].data.name
            this.data.positions[key].rules = positions[key].rules

            if(!('widgets' in this.data.positions[key])){
              this.data.positions[key].widgets = 'widgets' in positions[key] ? positions[key].widgets : []
            }
          }

          //Удаляем позиции (мусор)
          for(let key in this.data.positions) {
            if(!(key in positions)) {
              delete this.data.positions[key]
            }
          }
        }
      }
    }
  }
</script>

<style>

</style>