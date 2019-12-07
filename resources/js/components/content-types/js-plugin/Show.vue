<template>
  <div class="row">
    <div class="col">
      <div v-if="data !== null" class="content">

        <div class="title-and-special">

          <h2 class="heading">{{data.title}}</h2>

          <div class="special-links">
            <!--Ссылки автора-->
            <div class="more-info-section more-info-author-links">
              <div class="more-icon" title="Ссылки на плагин" :class="{'exist': !!data.meta_data.plugin_site || !!data.meta_data.plugin_github || !!data.meta_data.plugin_npm || !!data.meta_data.plugin_demo}">
                <fa icon="link"></fa>
              </div>
              <a class="btn btn-sm btn-outline-primary" v-if="!!data.meta_data.plugin_site" :href="data.meta_data.plugin_site" title="Сайт плагина" target="_blank">
                <fa icon="globe"></fa>
              </a>
              <a class="btn btn-sm btn-outline-primary" v-if="!!data.meta_data.plugin_github" :href="data.meta_data.plugin_github" title="GitHub" target="_blank">
                <fa :icon="['fab', 'github']"></fa>
              </a>
              <a class="btn btn-sm btn-outline-primary" v-if="!!data.meta_data.plugin_npm" :href="data.meta_data.plugin_npm" title="NPM" target="_blank">
                <fa :icon="['fab', 'npm']"></fa>
              </a>
              <a class="btn btn-sm btn-outline-primary" v-if="!!data.meta_data.plugin_demo" :href="data.meta_data.plugin_demo" title="Демо" target="_blank">
                <fa icon="eye"></fa>
              </a>
            </div>

            <!--todo в меню есть эти ссылки-->
            <!--Фиксы и улучшения плагина-->
            <!--<div class="more-info-section more-info-fix-extend-plugin"></div>
            <div class="more-icon" title="Фиксы и улучшения плагина">
              <fa icon="paperclip"></fa>
            </div>
            <div class="link-columns">
              <div class="link-row" v-if="!!curSubItems" v-for="item in curSubItems">
                <router-link v-if="item.is_router" :to="__getRouterData(item)" active-class="active"><span @click="onChangePage">{{ item.name }}</span></router-link><a v-else="" :href="item.path" @click="onChangePage">{{ item.name }}</a></div>
            </div>-->

            <!--Обучающий материал-->
            <div class="more-info-section more-info-training-material">
              <div class="more-icon" title="Обучающие материалы">
                <fa icon="graduation-cap"></fa>
              </div>
              <b-dropdown v-if="!!data.meta_data.teaching &amp;&amp; !!data.meta_data.teaching.length" variant="outline-primary" text="Обучающие материалы">
                <b-dropdown-item v-for="item in data.meta_data.teaching" :href="item.link" target="_blank" :key="item.title + '-' + item.link"><span>{{item.title}}&nbsp;</span><span><fa :icon="getIconFromUrl(item.link)"></fa></span></b-dropdown-item>
              </b-dropdown>
            </div>

            <!--Категории-->
            <div class="more-info-section more-info-cat">
              <div class="more-icon" title="Категории">
                <fa icon="folder"></fa>
              </div>
              <b-badge v-for="cat in data.categories" variant="default" :key="'cat:' + cat.id">{{cat.title}}</b-badge>
            </div>
          </div>

        </div>

        <div>

          <ClientPositionWidget v-if="!!data.meta_data.positions.alerts_scroll_test"
            :data="data.meta_data.positions.alerts_scroll_test"
          ></ClientPositionWidget>

          <ClientPositionWidget v-if="!!data.meta_data.positions.description"
            :data="data.meta_data.positions.description"
          ></ClientPositionWidget>

          <ClientPositionWidget v-if="!!data.meta_data.positions.tut_alerts"
            :data="data.meta_data.positions.tut_alerts"
          ></ClientPositionWidget>

          <ClientPositionWidget v-if="!!data.meta_data.positions.use_code"
            :data="data.meta_data.positions.use_code"
          ></ClientPositionWidget>

          <ClientPositionWidget v-if="!!data.meta_data.positions.content"
            :data="data.meta_data.positions.content"
          ></ClientPositionWidget>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import Form from 'vform'
  import axios from 'axios'
  import moment from 'moment'

  import {mixinShow} from '../mixinShow'

  export default {
    name: "ShowTable",

    mixins: [mixinShow],

    mounted: function () {
      this.__loadItem(this.$route.params.slug)
    },

    data: () => ({
      data: null
    }),

    computed: {

    },

    methods: {
      getIconFromUrl(url) {
        return appHelper.getFaIconServiceFromUrl(url);
      },

      __loadItem (slug) {
        axios
          .get('/api/content/js-plugin', {params: {slug}})
          .then(response => {
            this.data = response.data
            this.$emit('load', this.data)
          }).catch(err => {
            if(err.response.status == 404) {
              this.$router.push(404)
              console.log(err)
            }
        })
      }
    },

    watch: {
      language: function() {
        //Vue.nextTick( () => this.$refs.vuetable.refresh())
      }
    }
  }
</script>

<style scoped>
  .content {
    position: relative;
  }

  .title-and-special {
    display: flex;
  }

  .heading {
    margin-right: 10px;
  }

  .special-links {
    margin-left: auto;
    margin-top: -0.25rem;
    display: grid;
    grid-template-columns: 242px 224px;
    grid-template-rows: auto auto;
    grid-template-areas: "training-material author-links"
                          "cat cat";
  }

  .more-info-section {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    min-width: 0;
  }

  .more-info-section .more-icon {
    margin: 8px 5px 5px 0;
    position: relative;
    display: inline-block;
    z-index: 1;
  }

  .more-info-author-links {
    margin-left: 10px;
    grid-area: author-links;
  }

  .more-info-author-links .more-icon {
    margin-top: 11px;
  }

  .more-info-author-links .btn {
    margin: 0.25rem;
    width: 40px;
    font-size: 1.2rem;
  }

  .more-info-training-material {
    margin-top: 4px;
    grid-area: training-material;
  }

  .more-info-cat {
    grid-area: cat;
  }

  .more-info-cat .badge {
    color: #999;
  }

  .more-info-cat .more-icon {
    margin-top: -3px;
    margin-bottom: -3px;
  }
</style>