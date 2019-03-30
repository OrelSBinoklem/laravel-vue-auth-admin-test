<template>
  <div class="container-fluid pl-6">
    <div class="row">
      <div class="col">
        <div class="row">
          <div class="col-auto">
            <h1>{{$t('content')}}</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-2">
            <div class="list-group" v-if="contentTypes.length">
              <template v-for="(content_type, i) in contentTypes">
                <router-link :to="{ name: 'admin.content.type', params: { type: content_type.slug }}" active-class="active" class="list-group-item list-group-item-action" :key="content_type.slug">{{content_type.name}}</router-link>
              </template>
            </div>
            <div v-else class="alert alert-primary" role="alert">
              Нет типов контента!!!
            </div>
          </div>
          <div class="col-10">
            <div class="row" v-if="currentType !== null">
              <div class="col-12">
                <content-create-and-edit @updated="onUpdated" :type="currentType" :editData="editData" :edit="edit" :show="show"></content-create-and-edit>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Form from 'vform'
  import axios from 'axios'
  import _ from 'lodash'
  import ContentCreateAndEdit from "../../components/content-types/ContentCreateAndEdit";

  export default {
    layout: 'admin',
    middleware: ['auth', 'verified'],

    metaInfo () {
      return { title: this.$t('menus') }
    },

    components: {
      'content-create-and-edit': ContentCreateAndEdit
    },

    mounted: function () {
      if(this.$route.name === "admin.content") {
        this.$router.push({ name: 'admin.content.type', params: { type: this.contentTypes[0].slug } })
        this.currentType = this.contentTypes[0]
        this.show = true
      } else if(this.$route.name == 'admin.content.type') {
        this.show = true
      } else if(this.$route.name == 'admin.content.create') {
        this.edit = false
        this.show = false
      } else if(this.$route.name == 'admin.content.update') {
        this.edit = true
        this.show = false
      }

      if(
        this.$route.name == 'admin.content.type'
        || this.$route.name == 'admin.content.create'
        || this.$route.name == 'admin.content.update'
      ) {
        var type = _.find(this.contentTypes, {"slug": this.$route.params.type})
        if(type) {
          this.currentType = type
        } else {
          this.currentType = null
          this.$router.push({ name: 'admin.content'})
        }
      }

      if(this.$route.name == 'admin.content.update') {
        this.__loadEditItem(this.currentType.slug, this.$route.params.id)
      }
    },

    data: () => ({
      edit: false,
      show: true,
      editData: null,
      currentType: null,
      contentTypes: [
        {
          name: 'JS плагин',
          slug: 'js-plugin',
          component: 'js-plugin'
        }
      ]
    }),

    computed: {

    },

    methods: {
      onUpdated (e) {
        this.__loadEditItem(e.slug, e.id)
      },

      __loadEditItem (slug, id) {
        axios
          .get('/api/admin/content/' + slug + '/get-one', {params: {id}})
          .then(response => {
            this.editData = response.data
          }).catch(err => (console.log(err)))
      }
    },

    watch: {
      '$route.name': function(newVal, oldVal){
        if(newVal == 'admin.content.type') {
          this.show = true
        } else if(newVal == 'admin.content.create') {
          this.edit = false
          this.show = false
        } else if(newVal == 'admin.content.update') {
          this.edit = true
          this.show = false
        }
      },

      '$route.params': function(newVal, oldVal){
        if("type" in newVal) {
          this.currentType = _.find(this.contentTypes, {"slug": newVal.type});
        } else {
          this.currentType = null
        }

        if("id" in newVal && this.$route.name == 'admin.content.update') {
          this.__loadEditItem(this.currentType.slug, newVal.id)
        }
      },

      currentType: function (menu) {

      }
    }
  }
</script>

<style lang="sass" scoped>

</style>