<template lang="pug">


  .category-select(ref="container")
    b-form-select(:value="selected" @input="onSelect" :options="options" size="sm")


</template>

<script>

import Vue from 'vue';
import $ from 'jquery';
import _ from 'lodash';

export default {
  name: 'CategorySelect',

  components: {

  },

  props: {
    rootCategory: {type: String, default: null},
    defaultText: {type: String, default: 'Выберите опцию'}
  },

  data() {
    return {
      selected: null,
      defaultOption: { value: null, text: '' },
    }
  },

  async beforeMount () {
    await this.$store.dispatch('db/loadCategoriesPublic');

    this.defaultOption.text = this.defaultText;
  },

  mounted () {

  },

  computed: {
    options() {
      if(!!this.categories) {
        return [this.defaultOption].concat(
          this.categories.map((cat) => {
            return { value: cat.slug, text: cat.title };
          })
        );
      }
      else {
        return [this.defaultOption];
      }
    },

    categories() {
      if(!!this.rootCategory) {
        return this.$store.getters['db/categoriesPublicTree'](this.rootCategory);
      } else {
        return null;
      }
    }
  },

  methods: {
    onSelect(val) {
      this.selected = val;
      this.$emit('select', val);
    }
  },

  watch: {
    defaultText(val) {
      this.defaultOption.text = val;
    }
  }
}
</script>

<style lang="scss" scoped>

</style>

<style lang="scss">
  .category-select {
    select:focus {
      border-color: #ced4da;
      box-shadow: none;
    }
  }
</style>