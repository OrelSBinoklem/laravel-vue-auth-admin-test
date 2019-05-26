<template>
  <div class="row">
    <div class="col">
      <form @submit.prevent="addOrUpdatePlugin" @keydown="form.onKeydown($event)" action="" method="post">

        <div class="form-group row">
          <div class="col-md-12 d-flex">
            <!-- Submit Button -->
            <v-button v-if="!edit" block :loading="form.busy">
              Добавить плагин
            </v-button>
            <v-button v-else block :loading="form.busy">
              Обновить плагин
            </v-button>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <!-- Заголовок -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Заголовок</label>
              <div class="col-md-8">
                <input v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" class="form-control" type="text" name="title">
                <has-error :form="form" field="title"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Слаг -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Слаг</label>
              <div class="col-md-8">
                <input v-model="form.slug" :class="{ 'is-invalid': form.errors.has('slug') }" :disabled="edit" class="form-control" type="text" name="slug">
                <has-error :form="form" field="slug"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Описание -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Описание</label>
              <div class="col-md-8">
                <input v-model="form.description_short" :class="{ 'is-invalid': form.errors.has('description_short') }" class="form-control" type="text" name="description_short">
                <has-error :form="form" field="description_short"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Контент -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Контент</label>
              <div class="col-md-8">
                <input v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" type="text" name="description">
                <has-error :form="form" field="description"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Мета заголовок -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Мета заголовок</label>
              <div class="col-md-8">
                <input v-model="form.meta_title" :class="{ 'is-invalid': form.errors.has('meta_title') }" class="form-control" type="text" name="meta_title">
                <has-error :form="form" field="meta_title"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Мета описание -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Мета описание</label>
              <div class="col-md-8">
                <input v-model="form.meta_description" :class="{ 'is-invalid': form.errors.has('meta_description') }" class="form-control" type="text" name="meta_description">
                <has-error :form="form" field="meta_description"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Ключевые слова -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Ключевые слова</label>
              <div class="col-md-8">
                <input v-model="form.meta_keyword" :class="{ 'is-invalid': form.errors.has('meta_keyword') }" class="form-control" type="text" name="meta_keyword">
                <has-error :form="form" field="meta_keyword"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Опубликовано -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Опубликовано</label>
              <div class="col-md-8">
                <b-form-checkbox switch v-model='form.published' name='published'></b-form-checkbox>
                <div :class="{ 'is-invalid': form.errors.has('published') }"></div>
                <has-error :form="form" field="published"/>
              </div>
            </div>
          </div>
          <div class="col-6">
            <!-- Категории -->
            <div class="row tax" @click="onSelectCategories">
              <div class="col-4 text-right">Категории</div>
              <div class="col-8" v-if="form.categories_ids.length" v-html="__arrJoinQuotes(__findByIds(categories, form.categories_ids))"></div>
              <div class="col-8" v-else><b>Выберите категории</b></div>
            </div>
          </div>
          <div class="col-6">
            <!-- Тэги -->
            <div class="row tax" @click="onSelectTags">
              <div class="col-4 text-md-right">Тэги</div>
              <div class="col-8" v-if="form.tags_ids.length" v-html="__arrJoinQuotes(__findByIds(tags, form.tags_ids))"></div>
              <div class="col-8" v-else><b>Выберите тэги</b></div>
            </div>
          </div>

          <div class="col-12">
            <!-- Недочёты и предупреждения -->
            <div class="form-group row">
              <h4 class="col-md-12">Недостатки плагина</h4>
              <div v-for="(alert, index) in form.alerts" class="col-md-12 mb-2">
                <div class="row">
                  <div  class="col-md-6">
                    <input v-model="form.alerts[index].title" :class="{ 'is-invalid': form.errors.has(`alerts.${index}.title`) }" class="form-control" type="text" :name="'alert-title' + index">
                    <has-error :form="form" :field="`alerts.${index}.title`"/>
                  </div>
                  <div  class="col-md-6">
                    <input v-model="form.alerts[index].text" :class="{ 'is-invalid': form.errors.has(`alerts.${index}.text`) }" class="form-control" type="text" :name="'alert-text' + index">
                    <has-error :form="form" :field="`alerts.${index}.text`"/>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div @click="onAddAlert" class="btn btn-primary">Добавить алерт</div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Недочёты и предупреждения -->
            <div class="form-group row">
              <h4 class="col-md-12">Недостатки плагина</h4>
              <div class="col-md-12 mb-2">

              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Редакторы -->
            <div class="form-group row">
              <h4 class="col-md-12">Редакторы</h4>
              <div class="col-12">
                <div :class="{ 'is-invalid': form.errors.has('editors') }" class="form-control d-none"></div>
                <has-error :form="form" field="editors"/>
              </div>
              <div v-for="(alert, index) in form.editors" class="col-md-12 mb-2">
                <div :class="{ 'is-invalid': form.errors.has(`alerts.${index}`) }" class="form-control d-none"></div>
                <has-error :form="form" :field="`alerts.${index}`"/>
                <div class="row">
                  <div  class="col-md-6">
                    <input v-model="form.editors[index].slug" :class="{ 'is-invalid': form.errors.has(`editors.${index}.slug`) }" class="form-control" type="text" :name="'editor-slug' + index">
                    <has-error :form="form" :field="`editors.${index}.slug`"/>
                  </div>
                  <div  class="col-md-6">
                    <editor v-model="form.editors[index].text" @init="editorInit" lang="html" theme="chrome" width="100%" :height="150"></editor>
                    <div :class="{ 'is-invalid': form.errors.has(`editors.${index}.text`) }" class="form-control d-none"></div>
                    <has-error :form="form" :field="`editors.${index}.text`"/>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div @click="onAddEditor" class="btn btn-primary">Добавить редактор</div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Область для виджетов -->
            <div class="form-group row">
              <h4 class="col-md-12">Редакторы</h4>
              <div class="col-12">
                <AdminPosition
                        :edit="edit"
                        :form="form"
                        :data="form.positions.tut_alerts"
                        prefixDataForm="positions.tut_alerts"
                ></AdminPosition>
              </div>
            </div>
          </div>

        </div>

        <div class="form-group row">
          <div class="col-md-12 d-flex">
            <!-- Submit Button -->
            <v-button v-if="!edit" block :loading="form.busy">
              Добавить плагин
            </v-button>
            <v-button v-else block :loading="form.busy">
              Обновить плагин
            </v-button>
          </div>
        </div>
      </form>
    </div>
    <b-modal id="modal-select-categories"
             ref="modal-select-categories"
             title="Выберите категории"
             hide-footer>
      <!-- Категории -->
      <div class="row">
        <div class="col">
          <div v-for="(cat, index) in categories" :key="cat.id">
            <label :style="{paddingLeft: (cat.indent * 30) + 'px'}">
              <b-form-checkbox-group v-model="form.categories_ids" >
                <b-form-checkbox :value="cat.id">{{ cat.title }}</b-form-checkbox>
              </b-form-checkbox-group>
            </label>
          </div>
        </div>
      </div>
      <template slot="modal-cancel">Нет</template>
      <template slot="modal-ok">Да</template>
    </b-modal>
    <b-modal id="modal-select-tags"
             ref="modal-select-tags"
             title="Выберите тэги"
             hide-footer>
      <!-- Тэги -->
      <div class="row">
        <div class="col">
          <div v-for="(tag, index) in tags" :key="tag.id">
            <label>
              <b-form-checkbox-group v-model="form.tags_ids" >
                <b-form-checkbox :value="tag.id">{{ tag.title }}</b-form-checkbox>
              </b-form-checkbox-group>
            </label>
          </div>
        </div>
      </div>
      <template slot="modal-cancel">Нет</template>
      <template slot="modal-ok">Да</template>
    </b-modal>
  </div>
</template>

<script>
  import Vue from 'vue'
  import Form from 'vform'
  import axios from 'axios'
  import moment from 'moment'
  import { mapGetters } from 'vuex'

  import {mixinCreateAndEdit} from '../mixinCreateAndEdit'

  export default {
    name: "ContentCreateAndEdit",

    props: {
      edit: {
        type: Boolean,
        required: true
      },
      data: {
        type: Object
      }
    },

    mixins: [mixinCreateAndEdit],

    beforeMount() {
      this.__setDataForm(this.data)
    },

    data: () => ({
      curEdit: null,
      perPage: 10,
      moreParams: {},

      form: new Form({
        title: '',
        slug: '',
        description_short: '',
        description: '',
        meta_title: '',
        meta_description: '',
        meta_keyword: '',
        published: false,

        editors: [],

        alerts: [],
        categories_ids: [],
        tags_ids: [],
        positions: {
          'tut_alerts': {
            //todo убрать rules их нечегот хранить на сервере
            rules: [
              {
                name: /^alert$/gmi,
                count: 2,
                not: {
                  props: {
                    'variant': /^light|dark/gim
                  }
                }
              },
              {
                name: /^button$/gmi
              }
            ],
            widgets: []
          }
        }
      })
    }),

    computed: {
      ...mapGetters({
        language: 'lang/locale'
      })
    },

    methods: {
      // Column formatting
      createdAtLabel (value) {
        return moment(value).format("DD-MM-YYYY HH:mm")
      },
      async addOrUpdatePlugin () {
        if(this.edit) {
          await this.form.put('/api/admin/content/js-plugin/' + this.data.id)
          this.$emit('updated', {
            slug: 'js-plugin',
            id: this.data.id
          })
        } else {
          await this.form.post('/api/admin/content/js-plugin')
        }
      },

      onAddAlert () {
        this.form.alerts.push({
          title: '',
          text: ''
        })
      },

      onAddEditor () {
        this.form.editors.push({
          slug: '',
          text: ''
        })
      },

      onSelectCategories () {
        this.$root.$emit('bv::show::modal','modal-select-categories')
      },

      onSelectTags () {
        this.$root.$emit('bv::show::modal','modal-select-tags')
      },

      __setDataForm(data) {
        this.__reloadCategories()
        this.__reloadTags()

        if(data !== null && this.edit) {
          this.curEdit = this.data

          this.form.title = this.data.title
          this.form.slug = this.data.slug
          this.form.description_short = this.data.description_short
          this.form.description = this.data.description
          this.form.meta_title = this.data.meta_title
          this.form.meta_description = this.data.meta_description
          this.form.meta_keyword = this.data.meta_keyword
          this.form.published = !!this.data.published

          this.form.editors = this.data.meta_data.editors ? this.data.meta_data.editors : []

          this.form.alerts = this.data.meta_data.alerts ? this.data.meta_data.alerts : []
          this.form.categories_ids = this.__getIdsFromArr(data.categories)
          this.form.tags_ids = this.__getIdsFromArr(data.tags)
        }
      }
    },

    watch: {
      language: function() {
        //Vue.nextTick( () => this.$refs.vuetable.refresh())
      },

      data: function (newVal, oldVal) {
        this.__setDataForm(newVal)
      }
    }
  }
</script>

<style lang="sass" scoped>
  .tax
    cursor: pointer
</style>