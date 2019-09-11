<template lang="pug">
  .row
    .col-4
      b-form-input(v-model='data.props.navHash.title' placeholder="Название секции")
      .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.navHash.title`) }")
      has-error(:form='form', :field='`${prefixDataForm}.props.navHash.title`')
    .col-4
      b-form-input(v-model='data.props.navHash.slug' placeholder="Slug")
      .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.navHash.slug`) }")
      has-error(:form='form', :field='`${prefixDataForm}.props.navHash.slug`')
    .col-4
      b-form-select(v-model='data.props.navHash.group', :options='hashGroupsOptions')
      .form-control.d-none(:class="{ 'is-invalid': form.errors.has(`${prefixDataForm}.props.navHash.group`) }")
      has-error(:form='form', :field='`${prefixDataForm}.props.navHash.group`')
</template>

<script>

import Vue from 'vue'
import { mapGetters } from 'vuex'
import Form from 'vform'
import _ from 'lodash'

export default {
  components: {

  },

  props: {
    form: {
      type: Form,
      required: true
    },

    data: {
      type: Object,
      required: true
    },

    prefixDataForm: {
      type: String,
      required: true
    }
  },

  data: () => ({

  }),

  computed: {
    ...mapGetters({
      hashGroups: 'interface/hashGroups'
    }),

    hashGroupsOptions() {
      let r = [{value: null, text: 'Выберите группу'}];
      _.keysIn(this.hashGroups).forEach((group) => {
        r.push({value: group, text: this.hashGroups[group].title})
      });
      return r
    }

    /*typesVisibleOptions: [
        { value: null, text: 'Выберите вариант расположения редакторов' },
        { value: 'row', text: 'В одну строку' },
        { value: 'vertical_tabs', text: 'Вертикальные табы' },
        { value: 'casual', text: 'Обычными блоками' }
      ],*/
  },

  methods: {

  },

  beforeMount () {
    if(!('navHash' in this.data.props))
      Vue.set(this.data.props, 'navHash', {})

    if(!('title' in this.data.props.navHash))
      Vue.set(this.data.props.navHash, 'title', '')

    if(!('slug' in this.data.props.navHash))
      Vue.set(this.data.props.navHash, 'slug', '')

    if(!('group' in this.data.props.navHash))
      Vue.set(this.data.props.navHash, 'group', '')
  }
}
</script>

<style scoped lang="sass">

</style>
