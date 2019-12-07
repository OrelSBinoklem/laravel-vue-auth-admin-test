import Vue from 'vue'
import $ from 'jquery'
import _ from 'lodash';

export const mixin = {
  data() {
    return {
      domActive: null,
      active: null,
      isHoverCascade: false,

      topHoverItem: 0,
      subItemShowed: false,
      topSubItemOpacity: 1
    }
  },

  mounted() {
    this.unactiveDebounce = _.debounce(this.unactive, 10);
  },

  created() {

  },

  methods: {
    /**
     * Обработчик наведения курсора на пункты  меню
     * @param {Object} e - событие
     * @param {String} item - объект
     */
    onHover(e, item) {
      this.isHoverCascade = true;
      this.domActive = e.target;
      this.active = item;

      //для временного скрытия элемента перед точным расчётом позиции (надо спарсить высоту элемента чтоб посчитать позиция но при отображеннии элемента он может находиться в неправильной позиции поэтому на 1 тик его скрываем)
      this.topSubItemOpacity = 0;
      this.subItemShowed = false;
      Vue.nextTick(() => {
        this.topHoverItem = this.__getTopPositionItemByScroll(this.domActive);
        this.topSubItemOpacity = 1;
        //todo-mark чтоб рефрешился метод topSubItemOffsetWindow
        this.subItemShowed = true;
      });
    },

    onHoverSub() {
      this.isHoverCascade = true;
    },

    /**
     * Обработчик увода курсора на пункты первого уровня меню
     */
    onBloor() {
      this.isHoverCascade = false;
      this.unactiveDebounce();
    },

    onBloorSub() {
      this.isHoverCascade = false;
      this.unactiveDebounce();
    },

    unactive() {
      if (!this.isHoverCascade) {
        this.domActive = null;
        this.active = null;
      }
    },

    onChangePage() {
      this.$emit('change-page');
    },

    /**
     * Получение отступа сверху элемента с учетом скролла
     * @param {Object} domItem - элемент
     * @private
     */
    __getTopPositionItemByScroll(domItem) {
      return $(domItem).position().top - $(this.$refs.container).find(' > .__vuescroll > .__native').scrollTop();
    },

    /**
     * Получение максимальной высоты суб-меню
     * @returns {*|jQuery}
     * @private
     */
    __maxHeightItem() {
      return $(window).height()
    }
  },

  computed: {
    topSubItem() {
      return this.isSub ? this.topHoverItem - parseInt($('.dropdown-menu', this.$refs.container).css('padding-top')) : this.topHoverItem;
    },

    calculateTopSubItem() {
      if (!!this.active && !!this.active.children && !!this.active.children.length) {
        return this.topSubItem + this.topSubItemOffsetWindow;
      }

      return 0
    },

    topSubItemOffsetWindow() {
      if (this.subItemShowed && !!this.active && !!this.active.children && !!this.active.children.length) {
        let $sub = $('.contain-sub-item', this.$refs.container);
        //метод offset учитывает position fixed и увеличиваеться при прокрутке
        let top = this.topSubItem + $(this.$refs.container).offset().top;
        let bottom = this.topSubItem + $(this.$refs.container).offset().top + $sub.outerHeight();

        //Если субменю выходит за нижнюю границу экрана
        if (bottom > $(window).scrollTop() + $(window).height())
          return $(window).scrollTop() + $(window).height() - bottom;
      }

      return 0;
    }
  },

  watch: {},
}