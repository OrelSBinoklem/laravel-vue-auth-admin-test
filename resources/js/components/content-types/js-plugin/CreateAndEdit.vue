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
          <div class="col-6 mb-3">
            <!-- Тэги -->
            <div class="row tax" @click="onSelectTags">
              <div class="col-4 text-md-right">Тэги</div>
              <div class="col-8" v-if="form.tags_ids.length" v-html="__arrJoinQuotes(__findByIds(tags, form.tags_ids))"></div>
              <div class="col-8" v-else><b>Выберите тэги</b></div>
            </div>
          </div>

          <div class="col-12">
            <h3>Метаданные</h3>
          </div>

          <div class="col-12">
            <!-- Мета поле загрузки файла для плагина -->
            <div class="row">
              <div class="col-2 text-md-right">Файл плагина</div>
              <div class="col-md-4">
                <b-form-file v-model="form.meta_fields.plugin_file_data" :state="form.errors.has('meta_fields.plugin_file_data') ? false : !!form.meta_fields.plugin_file_data ? true : null" lang="ru" @change="onFilePluginChange" name="meta_fields_plugin_file_data" placeholder="Выберите файл или перетащите..." drop-placeholder="Давай бросай..." />
                <div class="form-control d-none" :class="{ 'is-invalid': form.errors.has('meta_fields.plugin_file_data') }"></div>
                <has-error :form="form" field="meta_fields.plugin_file_data"></has-error>
              </div>
              <div class="col-6">
                <div class="plugin-file-path" v-if="!!form.meta_fields.plugin_file">
                  <a :href="'/storage' + form.meta_fields.plugin_file" target="_blank" @click.prevent="downloadFile('/storage' + form.meta_fields.plugin_file)">
                    <span>{{'/storage' + form.meta_fields.plugin_file}}</span>
                    <fa icon="file-archive" />
                  </a>
                  <b-button class="btn-icon-delete" v-if="!!form.meta_fields.plugin_file || !!form.meta_fields.plugin_file_data" variant="outline-danger" @click="onDeleteFilePlugin">
                    <fa icon="times"></fa>
                  </b-button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <h4>Ссылки на плагин</h4>
          </div>

          <div class="col-6">
            <!-- Сайт плагина -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Сайт плагина</label>
              <div class="col-md-8">
                <input v-model="form.meta_fields.plugin_site" :class="{ 'is-invalid': form.errors.has('meta_fields.plugin_site') }" class="form-control" type="text" name="plugin_site">
                <has-error :form="form" field="meta_fields.plugin_site"/>
              </div>
            </div>
          </div>

          <div class="col-6">
            <!-- GitHub -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">GitHub</label>
              <div class="col-md-8">
                <input v-model="form.meta_fields.plugin_github" :class="{ 'is-invalid': form.errors.has('meta_fields.plugin_github') }" class="form-control" type="text" name="plugin_github">
                <has-error :form="form" field="meta_fields.plugin_github"/>
              </div>
            </div>
          </div>

          <div class="col-6">
            <!-- NPM -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">NPM</label>
              <div class="col-md-8">
                <input v-model="form.meta_fields.plugin_npm" :class="{ 'is-invalid': form.errors.has('meta_fields.plugin_npm') }" class="form-control" type="text" name="plugin_npm">
                <has-error :form="form" field="meta_fields.plugin_npm"/>
              </div>
            </div>
          </div>

          <div class="col-6">
            <!-- Demo -->
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">Демо</label>
              <div class="col-md-8">
                <input v-model="form.meta_fields.plugin_demo" :class="{ 'is-invalid': form.errors.has('meta_fields.plugin_demo') }" class="form-control" type="text" name="plugin_demo">
                <has-error :form="form" field="meta_fields.plugin_demo"/>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Обучающий материал -->
            <div class="form-group row">
              <h4 class="col-12">Обучающий материал</h4>
              <div class="col-12">
                <div :class="{ 'is-invalid': form.errors.has('meta_fields.teaching') }" class="form-control d-none"></div>
                <has-error :form="form" field="meta_fields.teaching"/>
              </div>
              <div v-for="(alert, index) in form.meta_fields.teaching" class="col-md-12 mb-2">
                <div :class="{ 'is-invalid': form.errors.has(`meta_fields.teaching.${index}`) }" class="form-control d-none"></div>
                <has-error :form="form" :field="`meta_fields.teaching.${index}`"/>
                <div class="row">
                  <div  class="col-md-6">
                    <input v-model="form.meta_fields.teaching[index].title" :class="{ 'is-invalid': form.errors.has(`meta_fields.teaching.${index}.title`) }" class="form-control" type="text" :name="'teaching-title' + index">
                    <has-error :form="form" :field="`meta_fields.teaching.${index}.title`"/>
                  </div>
                  <div  class="col-md-6">
                    <input v-model="form.meta_fields.teaching[index].link" :class="{ 'is-invalid': form.errors.has(`meta_fields.teaching.${index}.link`) }" class="form-control" type="text" :name="'teaching-link' + index">
                    <has-error :form="form" :field="`meta_fields.teaching.${index}.link`"/>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div @click="onAddTeaching" class="btn btn-primary">Добавить ссылку</div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Тест скролла по хешам -->
            <div class="form-group row">
              <h4 class="col-md-12">Тест скролла по хешам</h4>
              <div class="col-12">
                <AdminPosition
                        :edit="edit"
                        :form="form"
                        :data="form.positions.alerts_scroll_test"
                        prefixDataForm="positions.alerts_scroll_test"
                ></AdminPosition>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Зачем и как работает -->
            <div class="form-group row">
              <h4 class="col-md-12">Зачем и как работает</h4>
              <div class="col-12">
                <AdminPosition
                  :edit="edit"
                  :form="form"
                  :data="form.positions.description"
                  prefixDataForm="positions.description"
                ></AdminPosition>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Код для копирования -->
            <div class="form-group row">
              <h4 class="col-md-12">Код для копирования</h4>
              <div class="col-12">
                <AdminPosition
                  :edit="edit"
                  :form="form"
                  :data="form.positions.use_code"
                  prefixDataForm="positions.use_code"
                ></AdminPosition>
              </div>
            </div>
          </div>

          <div class="col-12">
            <!-- Недочёты и предупреждения -->
            <div class="form-group row">
              <h4 class="col-md-12">Недостатки плагина</h4>
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
  //import objectToFormData from 'object-to-formdata'
  import moment from 'moment'
  import { mapGetters } from 'vuex'

  import {mixinCreateAndEdit} from '../mixinCreateAndEdit'

  function objectToFormData(obj, rootName, ignoreList) {
    var formData = new FormData();

    function appendFormData(data, root) {
      root = root || '';
      if (data instanceof File) {
        formData.append(root, data);
      } else if (Array.isArray(data)) {
        if(!!data.length) {
          for (var i = 0; i < data.length; i++) {
            appendFormData(data[i], root + '[' + i + ']');
          }
        }
      } else if (typeof data === 'object' && data) {
        for (var key in data) {
          if (data.hasOwnProperty(key)) {
            if (root === '') {
              appendFormData(data[key], key);
            } else {
              appendFormData(data[key], root + '[' + key + ']');
            }
          }
        }
      } else {
        //if (data !== null && typeof data !== 'undefined') {
        if (typeof data !== 'undefined') {
          formData.append(root, data);
        }
      }
    }

    appendFormData(obj, rootName);

    return formData;
  }

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

        categories_ids: [],
        tags_ids: [],

        meta_fields: {
          plugin_file: '',
          plugin_file_data: null,
          plugin_site: null,
          plugin_github: null,
          plugin_npm: null,
          plugin_demo: null,
          teaching: [],
        },

        positions: {
          'alerts_scroll_test': {
            data: {
              name: 'Тест скролла по хешам'
            },
            rules: [
              {
                name: 'regex:/^alert$/mi'
              }
            ],
            widgets: []
          },

          'description': {
            //todo-fast убрать rules их нечего хранить на сервере и data
            data: {
              name: 'Зачем и как работает'
            },
            rules: [
              {
                name: 'regex:/^casual_html$/mi'
              }
            ],
            widgets: []
          },

          'tut_alerts': {
            //todo-fast убрать rules их нечего хранить на сервере и data
            data: {
              name: 'Недостатки плагина'
            },
            rules: [
              {
                name: 'regex:/^callout$/mi',
                props: {
                  'variant': ['regex:/^danger|warning$/im']
                }
                //count: 2,
                /*not: {
                  props: {
                    'variant': ['regex:/^(light|dark)$/im']
                  }
                }*/
              },
              /*{
                name: 'regex:/^button$/imu'
              }*/
            ],
            widgets: []
          },

          'use_code': {
            //todo-fast убрать rules их нечего хранить на сервере и data
            data: {
              name: 'Код для копирования'
            },
            rules: [
              {
                name: 'regex:/^copy_code$/mi'
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
          await this.form.submit('post', '/api/admin/content/js-plugin/' + this.data.id, {
            transformRequest: [function (data, headers) {
              return objectToFormData(data)
            }],
            onUploadProgress: e => {
              // Do whatever you want with the progress event
              // console.log(e)
            }
          });

          this.$emit('updated', {
            slug: 'js-plugin',
            id: this.data.id
          })
        } else {
          await this.form.submit('post', '/api/admin/content/js-plugin', {
            transformRequest: [function (data, headers) {
              return objectToFormData(data)
            }],
            onUploadProgress: e => {
              // Do whatever you want with the progress event
              // console.log(e)
            }
          });
        }
      },

      onSelectCategories () {
        this.$root.$emit('bv::show::modal','modal-select-categories')
      },

      onSelectTags () {
        this.$root.$emit('bv::show::modal','modal-select-tags')
      },

      onFilePluginChange(e) {
        this.form.icon_data = e.target.files[0];
      },

      onDeleteFilePlugin() {
        this.form.meta_fields.plugin_file = '';
        this.form.meta_fields.plugin_file_data = null;
      },

      downloadFile (url) {
        axios.get(url, { responseType: 'blob' })
          .then(({ data }) => {
            const blob = new Blob([data], { type: 'application/zip' })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = url.substring(url.lastIndexOf('/')+1)
            link.click()
          }).catch(error => console.error(error))
      },

      onAddTeaching () {
        this.form.meta_fields.teaching.push({
          title: '',
          link: ''
        });
        console.log(this.form.meta_fields.teaching);
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

          this.form.categories_ids = this.__getIdsFromArr(data.categories)
          this.form.tags_ids = this.__getIdsFromArr(data.tags)

          let meta_fields = [
            'plugin_file',

            'plugin_site',
            'plugin_github',
            'plugin_npm',
            'plugin_demo',

            'teaching',
          ];
          for(let val of meta_fields)
            if(_.hasIn(this, 'data.meta_data.' + val))
              this.form.meta_fields[val] = this.data.meta_data[val];

          for(let key in this.form.positions) {
            if('positions' in this.data.meta_data && key in this.data.meta_data.positions && 'widgets' in this.data.meta_data.positions[key]) {
              this.form.positions[key].widgets = this.data.meta_data.positions[key].widgets
            }
          }
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

  .btn-file-delete
    display: none
    position: absolute
    top: 0
    right: 0
  .icon-img-card:hover .btn-file-delete
    display: block
</style>