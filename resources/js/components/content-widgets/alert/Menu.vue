<template lang="pug">
  span(v-if="!megamenu" @click="onClick") Alert
  .row(v-else)
    .col-3(@click="onClick('primary')"): b-alert(show variant='primary') Primary Alert
    .col-3(@click="onClick('secondary')"): b-alert(show variant='secondary') Secondary Alert
    .col-3(@click="onClick('success')"): b-alert(show variant='success') Success Alert
    .col-3(@click="onClick('danger')"): b-alert(show variant='danger') Danger Alert
    .col-3(@click="onClick('warning')"): b-alert(show variant='warning') Warning Alert
    .col-3(@click="onClick('info')"): b-alert(show variant='info') Info Alert
    .col-3(@click="onClick('light')"): b-alert(show variant='light') Light Alert
    .col-3(@click="onClick('dark')"): b-alert(show variant='dark') Dark Alert
</template>

<script>
  import {mixinMenu} from '../mixinMenu'

  export default {
    name: "Menu",

    mixins: [mixinMenu],

    components: {

    },

    props: {
      megamenu: {
        type: Boolean,
        required: true
      }
    },

    data: () => ({

    }),

    computed: {

    },

    methods: {
      onClick(variant) {
        if(this.current !== null) {
          if(variant) {
            this.current.widgets.push({
              name: 'alert',
              props: {
                variant,
                html: ''
              }
            })
          } else {
            this.current.widgets.push({
              name: 'alert'
            })
          }
        }
      }
    },

    watch: {

    }
  }
</script>

<style>

</style>