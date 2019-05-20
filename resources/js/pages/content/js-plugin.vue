<template>
  <show></show>
</template>

<script>
  import Show from "../../components/content-types/js-plugin/Show";

  export default {
    layout: 'plain-plugins',

    metaInfo () {
      //todo-orel перевод
      return {
        title: '',
        titleTemplate: 'Простая зборка - %s'
      }
    },

    components: {
      Show
    },
  }
</script>