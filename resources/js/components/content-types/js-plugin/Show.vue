<template>
  <div class="row">
    <div class="col">
      <div v-if="data !== null" class="content">
        <h2>{{data.title}}</h2>
        <div>
          <div v-for="alert in data.meta_data.alerts" class="bs-callout bs-callout-warning">
            <h4>{{alert.title}}</h4>
            <p>{{alert.text}}</p>
          </div>
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
      __loadItem (slug) {
        axios
          .get('/api/content/js-plugin', {params: {slug}})
          .then(response => {
            this.data = response.data
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

<style>

</style>