<template>
  <div>
    <div class="bs-callout bs-callout-info">
      <p>Здесь вы найдёте:</p>
      <ol>
        <li>Отборные плагины для вэб-разработки</li>
        <li>Плагины автора сайта и возможно некоторых других</li>
        <li>Заготовки кода</li>
      </ol>
    </div>
    <div class="bs-callout bs-callout-info">
      <p>Все эти плагины также находяться в зборке в разделе <b>"Инструменты"</b></p>
    </div>
    <div class="bs-callout bs-callout-warning">
      <p>Самые свежие версии плагинов на <b>JQuery</b> находяться только в зборке где они устанавливаються через npm, здесь код <b>обновлять часто небуду</b> (только по жалобе в обратной связи...) так как большинство плагинов хорошо проработанная классика!!!</p>
    </div>
  </div>
</template>

<script>
  import {contentTypes} from "../../components/content-types/contentTypes";
  import _ from 'lodash'

  import {mContentHashes} from '../../components/scroll-hash/mContentHashes'

  export default {
    layout: 'plain-plugins',

    metaInfo () {
      //todo-orel перевод
      const { appName } = window.config

      return {
        title: 'Вэб-программирование',
        titleTemplate: `${appName} - %s`
      }
    },

    mixins: [mContentHashes],

    components: {

    },

    data() {
      return {

      }
    },

    methods: {
      onLoad(data) {
        this.$store.dispatch('interface/setNavHashes', this.parseHashes({}))

      }
    },

    created() {
      this.$store.dispatch('interface/setHashGroups', _.find(contentTypes.get().contentTypes, {slug: 'js-plugin'}).hashGroups)
    },

    mounted: function () {

    }
  }
</script>