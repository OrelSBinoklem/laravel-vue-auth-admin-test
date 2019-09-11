<template lang="pug">
  .menu.menu-grouped-hashes(ref="container")
    vue-scroll(ref="scroll" :ops="{bar: {background: '#4285f4', onlyShowBarOnScroll: false}, scrollPanel: {scrollingX: false}}")
      .scroll
        .g-wrap(
          v-if="!!renderedGroupsAndSlides && !!renderedGroupsAndSlides.length"
          v-for="(group, i) in renderedGroupsAndSlides"
          :style="{height: !!group.height && !modeNoSlider ? group.height + 'px' : 'auto'}")
          .group
            .g-title(
              :title="group.group in groups ? groups[group.group].title : 'Без группы'")
              | {{group.group in groups ? groups[group.group].title : 'Без группы'}}
            .g-items
              //todo-hack v-show чтобы неглючил слик слайдер
              .g-scroll(v-show="!modeNoSlider" @click="(e) => {onUserChangeSlide(i, e);}")
                slick(ref='slick' :options='slickOptions')
                  div(v-for="slide in group.slides")
                    .g-slide(:style="{columnCount: columnsSlide}")
                      .g-item(
                        v-for="item in slide"
                        :title="item.title"
                        :class="{active: ((!!item.group ? item.group + '-' : '') + item.slug) === currentHashTemp, 'active-scrolled': ((!!item.group ? item.group + '-' : '') + item.slug) === currentHashScrolled}"
                        @click="onSelect(item)") {{item.title}}
              .g-scroll(v-if="modeNoSlider")
                .g-slide(:style="{columnCount: columnsSlide}")
                  .g-item.__full-text(
                    v-for="item in group.items"
                    :title="item.title"
                    :class="{active: ((!!item.group ? item.group + '-' : '') + item.slug) === currentHashTemp, 'active-scrolled': ((!!item.group ? item.group + '-' : '') + item.slug) === currentHashScrolled}"
                    @click="onSelect(item)") {{item.title}}
</template>

<script>
  import Vue from 'vue'
  import $ from 'jquery'
  import _ from 'lodash';

  import vuescroll from 'vuescroll';
  Vue.use(vuescroll);

export default {
  components: {

  },

  props: {
    currentHash: {type: String, required: true},
    currentHashScrolled: {type: String, required: true},
    groups: {type: Object, required: true},
    hashes: {type: Array, required: true},

    modePriorityGroup: {
      validator: (value) => {
        return typeof value == 'object'
          && 'sizeFactor' in value
          && typeof value.sizeFactor == 'number'
          && 'percentageOfMenuItemsRelativeToArithmeticMean' in value
          && typeof value.percentageOfMenuItemsRelativeToArithmeticMean == 'number'
          || value === false;
      },
      default: () => {return {sizeFactor: 2, percentageOfMenuItemsRelativeToArithmeticMean: 150}}
    },
    modeNoSlider: {type: Boolean, default: false},
    maxGroupsHeightPercent: {type: Number, default: 25},
    minMaxGroupsHeightPx: {type: Number, default: 150},
    columnsSlide: {type: Number, default: 2},
  },

  data: () => ({
    currentHashTemp: '',
    userSelectedSlides: [],
    //todo-mark связано со стилями
    heightDots: 2,
    //\
    slickOptions: {
      slidesToShow: 1,
      slidesToScroll: 1,
      speed: 100,
      dots: true,
      infinite: false,
      prevArrow: '<button type="button" class="slick-prev"></button>',
      nextArrow: '<button type="button" class="slick-next"></button>'
    },
    renderedGroupsAndSlides: null
  }),

  computed: {
    /**
     * Группируем элементы когда в них вподряд встречаеться одна и таже группа (чтобы не разрушать порядок элементов меню, сгруппировав их просто по группам)
     * @returns {[]}
     */
    renderedGroups() {
      let result = [];
      let curGroup = null;

      this.hashes.forEach((item) => {
        if(curGroup !== item.group) {
          curGroup = item.group;
          result.push({group: item.group, items: [item]});
        } else {
          result[result.length - 1].items.push(item);
        }
      });

      return result;
    },
  },

  methods: {
    /**
     *  Общий метод вызывающий цепь действий
     *
     *  -> Установка высоты групп
     *      с учётом увеличенной высоты для групп имеющих много элементов "modePriorityGroup"
     *      с учётом отступа для пєйджера слайдера
     *  -> группировка пунктов по слайдам
     *  -> реинициализация slick slider
     */
    renderSlidesAndSlickReinit(saveCurSlides = true) {
      if(!!this.renderedGroups) {
        if($('.g-title', this.$refs.container).length && $('.g-item', this.$refs.container).length) {

          this.setHeightGroupsAndCalculateMaxItemsOneSlide(this.renderedGroups, this.maxGroupsHeightPercent, this.columnsSlide);
          this.renderedGroupsAndSlides = this.groupedSlides(this.renderedGroups);

          if(this.$refs.slick)
            this.$nextTick(() => {
              this.$refs.slick.forEach((slick) => {
                let currIndex = slick.currentSlide();

                slick.destroy();
                this.$nextTick(() => {
                  slick.create();
                  if(saveCurSlides)
                    slick.goTo(currIndex, true);
                  else
                    this.changeSlideToActiveAndScrolled(this.renderedGroups);
                });
              });
            });

        } else {

          this.renderedGroups.forEach((group) => {group.slides = [group.items]});
          this.renderedGroupsAndSlides = this.renderedGroups;
          this.$nextTick(() => {

            this.setHeightGroupsAndCalculateMaxItemsOneSlide(this.renderedGroups, this.maxGroupsHeightPercent, this.columnsSlide);
            this.renderedGroupsAndSlides = this.groupedSlides(this.renderedGroups);

            if(this.$refs.slick)
              this.$nextTick(() => {
                this.$refs.slick.forEach((slick) => {
                  let currIndex = slick.currentSlide();

                  slick.destroy();
                  this.$nextTick(() => {
                    slick.create();
                    if(saveCurSlides)
                      slick.goTo(currIndex, true);
                    else
                      this.changeSlideToActiveAndScrolled(this.renderedGroups);
                  });
                });
              });

          })

        }
      }
    },

    setHeightGroupsAndCalculateMaxItemsOneSlide(groups, maxHeightPercent, columnsSlide) {
      if(groups.length) {
        //Вычисляем пространство занимаемое по высоте кроме контента
        let hContainer = $('.scroll', this.$refs.container).height();
        let outsideGroupWrap = $('.g-wrap', this.$refs.container).outerHeight(true) - $('.g-wrap', this.$refs.container).height();
        let outsideGroup = $('.group', this.$refs.container).outerHeight(true) - $('.group', this.$refs.container).height();
        let hTitle = $('.g-title', this.$refs.container).first().outerHeight(true);
        let hItem = $('.g-item', this.$refs.container).first().outerHeight();

        let outsideHeight = outsideGroupWrap + outsideGroup + hTitle;
        let maxHeight = hContainer * maxHeightPercent / 100 < this.minMaxGroupsHeightPx
          ? this.minMaxGroupsHeightPx
          : hContainer * maxHeightPercent / 100;

        const avgItems = groups.reduce((acc, group) => acc + group.items.length, 0) / groups.length;

        groups.forEach((group) => {

          //Учитываем увеличение высоты по пропсу "modePriorityGroup"
          let maxHeightPriority = !!this.modePriorityGroup && group.items.length > avgItems * this.modePriorityGroup.percentageOfMenuItemsRelativeToArithmeticMean / 100
            ? maxHeight * this.modePriorityGroup.sizeFactor
            : maxHeight;

          let isManySlides = group.items.length > Math.floor((maxHeightPriority - outsideHeight) / hItem) * columnsSlide;

          let rows = Math.ceil( group.items.length / columnsSlide );

          if(rows * hItem + outsideHeight + (isManySlides ? this.heightDots : 0) > maxHeightPriority) {
            Vue.set(group, 'height', maxHeightPriority);
          } else {
            Vue.set(group, 'height', rows * hItem + outsideHeight + (isManySlides ? this.heightDots : 0));
          }

          group.maxItemsOneSlide = Math.floor((maxHeightPriority - outsideHeight - (isManySlides ? this.heightDots : 0)) / hItem) * columnsSlide;

        });
      }
    },

    /**
     * Группируем элементы для слайдеров в каждой группе
     * @param groups
     */
    groupedSlides(groups) {
      groups.forEach((group) => {

        this.$nextTick(function() {
          Vue.set(group, 'slides', _.chunk(group.items, group.maxItemsOneSlide));
        });

      });
      return groups;
    },

    /**
     * Установка слайдов в слайдерах с учётом:
     *    *активного пункта: props.currentHash
     *    *проскроленного пункта: props.currentHashScrolled
     *    *слайдов что выбирал пользователь ранее: userSelectedSlides
     * @param groups
     */
    changeSlideToActiveAndScrolled(groups) {
      groups.forEach((group, i) => {

        let scrolled = false;
        let active = false;
        let userSelect = false;

        group.slides.forEach((slide, j) => {
          slide.forEach((item) => {

            if(scrolled === false && this.currentHashScrolled === (!!item.group ? item.group + '-' : '') + item.slug)
              scrolled = j;

            if(active === false && this.currentHashTemp === (!!item.group ? item.group + '-' : '') + item.slug)
              active = j;

            if(userSelect === false && this.userSelectedSlides[i] === j)
              userSelect = j;
          });
        });

        if(scrolled !== false) {
          if(this.$refs.slick[i].currentSlide() !== scrolled)
            this.$refs.slick[i].goTo(scrolled, true);
        }

        else if(active !== false) {
          if(this.$refs.slick[i].currentSlide() !== active)
            this.$refs.slick[i].goTo(active, true);
        }
        else if(userSelect !== false) {
          if(this.$refs.slick[i].currentSlide() !== userSelect)
            this.$refs.slick[i].goTo(userSelect, true);
        }

      });
    },

    /**
     * Центрируем скролл так чтобы выделенный элемент был по центру вертикали
     * @param {boolean|null} scrollActive null - оба типа но в приоритете активный, true - активный, false - активно-проскроленный
     * @param {number} speed
     */
    scrolledToActiveOrScrolledItem(scrollActive = null, speed = 500) {
      let cTop = $(this.$refs.container).offset().top;
      let cHeight = $(this.$refs.container).outerHeight();
        let cBottom = cTop + cHeight;
        let centerContainer = cTop + cHeight / 2;

        //todo-mark :visible потому что используеться не v-if для отображения элементов а v-show "v-show чтобы неглючил слик слайдер"
      let item = $(
        scrollActive === null
        ? '.g-item.active:visible, .g-item.active-scrolled:visible'
        : '.g-item.active' + (scrollActive ? '' : '-scrolled') + ':visible',
        this.$refs.container
      ).first();

      if(item.length) {
        if(cTop > item.offset().top || cBottom < item.offset().top + item.outerHeight()) {
          this.$refs.scroll.scrollTo(
            {
              y: $(this.$refs.container).find(' > .__vuescroll > div').scrollTop() + item.offset().top + item.outerHeight() / 2 - centerContainer
            },
            speed,
            'easeInQuad'
          );
        }
      }
    },

    onSelect(item) {
      this.currentHashTemp = (!!item.group ? item.group + '-' : '') + item.slug;
      this.$emit('update:current-hash', this.currentHashTemp);
    },

    onUserChangeSlide(i, e) {
      if($(e.target).closest('.slick-dots, .slick-arrow').length)
        this.userSelectedSlides[i] = this.$refs.slick[i].currentSlide();
    }
  },

  watch: {
    renderedGroups: function (val) {
      this.userSelectedSlides = Array(val.length).fill(0);
      this.renderSlidesAndSlickReinit(false);
      this.$nextTick(() => {
        this.$nextTick(() => {
          this.$nextTick(() => {
            this.scrolledToActiveOrScrolledItem(null, 0);
          });
        });
      });
    },

    modeNoSlider: function (val) {
      if(!val)
        this.$nextTick(() => {
          this.renderSlidesAndSlickReinit();
        });

      this.$nextTick(() => {
        this.$nextTick(() => {
          this.$nextTick(() => {
            this.scrolledToActiveOrScrolledItem(false, 0);
          });
        });
      });
    },

    currentHash(val) {
      if(this.currentHashTemp !== val) {
        this.currentHashTemp = val;
        this.$nextTick(() => {
          this.scrolledToActiveOrScrolledItem(true);
        });

      }
    },

    currentHashScrolled(val) {
      this.$nextTick(() => {
        this.scrolledToActiveOrScrolledItem(false);
      });
    }
  },

  mounted() {
    this.userSelectedSlides = Array(this.renderedGroups.length).fill(0);

    this.$watch(
      function () {
        return this.currentHashTemp.length + ':' + this.currentHashTemp + this.currentHashScrolled + ':' + this.currentHashScrolled.length;
      },
      function (newVal, oldVal) {
        this.changeSlideToActiveAndScrolled(this.renderedGroups);
      }
    );

    this.renderSlidesAndSlickReinitThrottle = _.throttle(() => {
      if(!this.modeNoSlider)
        this.renderSlidesAndSlickReinit();
    }, 500);

    this.$nextTick(function() {
      window.addEventListener('resize', this.renderSlidesAndSlickReinitThrottle);

      //Init
      this.renderSlidesAndSlickReinitThrottle();
    });

    this.$nextTick(() => {
      this.$nextTick(() => {
        this.$nextTick(() => {
          this.scrolledToActiveOrScrolledItem(null, 0);
        });
      });
    });
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.renderSlidesAndSlickReinitThrottle);
  }
}
</script>

<style scoped lang="scss">
  .menu {
    width: 100%;
    height: 100%;
    background-color: #fff;
  }

  .scroll {
    padding: 3px;
  }

  .g-wrap {
    padding: 3px;
  }

  .group {
    display: flex;
    flex-direction: column;
    padding: 6px;
    height: 100%;
    overflow: hidden;
    background-color: #F7F9FB;
    outline: 1px solid #7DBCFB;
    outline-offset: -1px;
  }

  $title-height: 20px;

  .g-title {
    margin-right: 75px;
    height: $title-height;
    font-size: 14px;
    line-height: 1;
    font-weight: bold;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    flex: 0 0 auto;
  }

  .g-items {
    height: calc(100% - #{$title-height});
    flex-grow: 1;
    flex-basis: 0;
  }

  .g-scroll {
    height: 100%;
  }

  .g-slide {
    display: block !important;
    column-gap: 6px;
  }

  .g-item {
    font-size: 14px;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
  }

  .g-item:hover {
    background-color: #E4E4E4;
    box-shadow: 3px 0 0 0 #E4E4E4, -3px 0 0 0 #E4E4E4;
  }

  .g-item.active-scrolled {
    background-color: #B5D8FB;
    box-shadow: 3px 0 0 0 #B5D8FB, -3px 0 0 0 #B5D8FB;
  }

  .g-item.active {
    background-color: #FBD2A9;
    box-shadow: 3px 0 0 0 #FBD2A9, -3px 0 0 0 #FBD2A9;
    cursor: default;
  }

  .g-item.__full-text {
    text-overflow: clip;
    white-space: normal;
  }

</style>

<style lang="scss">
  .menu-grouped-hashes {
    .slick-slider {
      margin-left: -3px;
      margin-right: -3px;
      height: 100%;
    }

    .slick-slide {
      padding-left: 3px;
      padding-right: 3px;
    }
    .slick-slide > div > div {
      display: block !important;
    }

    .slick-dots {
      list-style: none;
      margin: 0;
      padding: 0;
      position: absolute;
      left: -1px;
      right: -1px;
      bottom: -4px;
      height: 8px;
      display: flex;
    }

    .slick-dots li {
      flex-grow: 1;
    }

    .slick-dots li:nth-child(n + 2) {
      margin-left: 5px;
    }

    .slick-dots button {
      display: block;
      padding: 0;
      width: 100%;
      height: 100%;
      border: 1px solid #FBBA78;
      background-color: #FBF9F7;
      outline: none;
      overflow: hidden;
      text-indent: -999px;
    }

    .slick-dots .slick-active button {
      background-color: #FBBA78;
    }

    .slick-arrow {
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: -25px;
      right: -2px;
      width: 40px;
      height: 25px;
      padding: 0;
      border: none;
      outline: none;
      overflow: hidden;
      background-color: transparent;
    }

    .slick-arrow:hover {
      background-color: #eee;
    }

    .slick-arrow.slick-disabled {
      background-color: transparent;
      opacity: 0.5;
    }

    .slick-prev {
      right: 38px;
    }

    .slick-arrow:after {
      display: block;
      font-size: 16px;
      line-height: 1;
      font-weight: bold;
      transform: scale(1, 1.2);
    }

    .slick-prev:after {
      content: "\003c";
    }

    .slick-next:after {
      content: "\003e";
    }
  }
</style>
