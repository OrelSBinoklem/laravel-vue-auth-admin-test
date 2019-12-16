<template lang="pug">


  ul.mainmenu(ref="container")
    li.item(v-for="item in items" :title="item.name" :class="[curItemCube === item ? 'hover' : '', item.class]")
      .item-shadow
      .item-cube
        .item-front: img(v-if="!!item.icon" :src="'/storage' + item.icon")
        .sub-menu-visualezed
          span(v-for="item in item.children" :class="{hover: curItem === item}") {{item.name}}
      ul.sub-menu(@mouseenter="onMouseenterCube(item)" @mouseleave="onMouseleaveCube")
        li.sub-item(v-for="item in item.children" @mouseenter="onMouseenter(item)" @mouseleave="onMouseleave")
          router-link(v-if='item.is_router != false', :to='__getRouterData(item)', active-class='active')
          a(v-else='', :href='item.path')


</template>

<script>
import {menuHelpers} from '../menu-items/menu-helpers';

export default {
  name: 'MainMenu',

  mixins: [menuHelpers],

  components: {

  },

  props: {
    items: {type: Array, required: true}
  },

  data() {
    return {
      curItem: null,
      curItemCube: null
    }
  },

  computed: {

  },

  beforeMount() {

  },

  async mounted () {
    console.log(this.items)
  },

  beforeDestroy() {

  },

  methods: {
    onMouseenter(item) {
      this.curItem = item
    },

    onMouseleave() {
      this.curItem = null
    },

    onMouseenterCube(item) {
      this.curItemCube = item
    },

    onMouseleaveCube() {
      this.curItemCube = null
    },

    __getRouterData(item) {
      return {...item.router};
    }
  },

  watch: {

  }
}
</script>

<style lang="scss" scoped>
  .mainmenu {
    list-style: none;
    margin: 0;
    padding: 0;
    width: 480px;
    height: 480px;
    position: relative;
    //transform-style: flat;
    //perspective: 1500px;
  }

  .item {
    position: absolute;
    width: 120px;
    height: 80px;
    transform-style: flat;
    perspective: 500px;
  }

  .item-shadow {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 10px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.5);
    box-shadow: 0 0 20px 10px rgba(0, 0, 0, 1);
  }

  .item-web-programming {
    top: 0;
    left: 0;
  }

  .item-programming {
    top: calc(50% - 40px);
    left: 0;
    opacity: 0.5;
  }

  .item-main-multimedia {
    top: 0;
    right: 0;
    opacity: 0.5;
  }

  .item-3d-graphics-and-games {
    top: calc(50% - 40px);
    right: 0;
    opacity: 0.5;
  }

  .item-ai-and-robots {
    left: calc(50% - 40px);
    bottom: 0;
    opacity: 0.5;
  }

  .item-cube {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform-style: preserve-3d;
    transform-origin: 50% 50% -60px;
    transition: transform 0.3s;
  }

  .item-web-programming.hover .item-cube {
    transform: rotateY(-90deg);
  }

  .item-programming.hover .item-cube {
    transform: rotateY(-90deg);
  }

  .item-main-multimedia.hover .item-cube {
    transform: rotateY(90deg);
  }

  .item-3d-graphics-and-games.hover .item-cube {
    transform: rotateY(90deg);
  }

  .item-ai-and-robots.hover .item-cube {
    transform: rotateY(90deg);
  }

  .item-front {
    position: absolute;
    top: 0;
    left: 0;
  }

  .sub-menu-visualezed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    background: #fff;
    transform-origin: 50% 50% -60px;
    transition: transform 0.3s;
  }

  .sub-menu-visualezed span {
    display: block;
    width: 100%;
    flex-grow: 1;
    flex-basis: 0;
    padding-left: 15px;
    font-size: 14px;
    line-height: 26px;
    font-weight: bold;
  }

  .sub-menu-visualezed span.hover {
    background: #eee;
  }

  .item-web-programming .sub-menu-visualezed {
    transform: rotateY(90deg);
  }

  .item-programming .sub-menu-visualezed {
    transform: rotateY(90deg);
  }

  .item-main-multimedia .sub-menu-visualezed {
    transform: rotateY(-90deg);
  }

  .item-3d-graphics-and-games .sub-menu-visualezed {
    transform: rotateY(-90deg);
  }

  .item-ai-and-robots .sub-menu-visualezed {
    transform: rotateY(-90deg);
  }

  .sub-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    opacity: 0;
  }

  .sub-item {
    width: 100%;
    flex-grow: 1;
    flex-basis: 0;
  }

  .sub-menu a {
    display: block;
    height: 100%;
  }

</style>

<style lang="scss">

</style>