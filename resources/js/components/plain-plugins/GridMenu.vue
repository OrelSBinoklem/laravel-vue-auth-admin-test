<template lang="pug">


  .grid-menu(ref="container")
    .header(ref="header").clearfix

      .column(
        ref="column"
        v-for="(col, j) in data.cols"
        :class="{'hover-col': curBtnHover.col === j}"
        :style="{width: 100 - (data.cols.length > 1 ? headerFreeSpaceShift : 100) + '%', marginLeft: headerFreeSpaceShift / (data.cols.length - 1) * j + '%'}") {{col}}
      .line(
        v-for="(line, j) in headerLines"
        :class="{'hover-col': curBtnHover.col === j}"
        :style="{top: line.t + 'px', left: line.l + 'px', height: line.h + 'px'}")
    .rows-buttons

      .rows
        .one-row(v-for="(row, i) in data.rows" :class="{'hover-row': curBtnHover.row === i}")
          div.one-row-icon.icon-jquery(v-if="row.icon[0] === 'custom' && row.icon[1] === 'jquery'" :style='{color: row.color}')
            svg.svg-inline--fa.fa-w-16.fa-lg(role="img" viewBox='0 0 29 29' xmlns='http://www.w3.org/2000/svg')
              path(d='M17.192 0.00570486C17.1245 0.0157049 17.057 0.0357049 16.992 0.0657049C16.442 0.338205 15.817 1.1482 15.697 1.3082C15.6895 1.3182 15.682 1.3282 15.677 1.3382C15.0595 2.2632 14.7295 3.34571 14.717 4.4732C14.7095 5.3182 14.8745 6.1557 15.2095 6.9632C15.9895 8.8357 17.6095 10.3857 19.537 11.1107C19.602 11.1332 19.6645 11.1557 19.777 11.1957C19.787 11.2007 19.882 11.2307 19.897 11.2332L19.967 11.2582C20.067 11.2907 20.1695 11.3232 20.2695 11.3432C20.777 11.4457 21.272 11.5032 21.737 11.5182C21.817 11.5182 21.897 11.5207 21.977 11.5207C25.4845 11.5207 26.8445 9.0457 27.297 8.2207C27.342 8.1407 27.3745 8.0757 27.4045 8.0357C27.4045 8.0332 27.4045 8.0332 27.407 8.0307C27.6045 7.7382 27.5295 7.3407 27.237 7.1407C26.947 6.9432 26.5495 7.0182 26.3495 7.3107H26.347C25.412 8.6882 23.812 9.1057 21.5945 8.5557C21.4295 8.5157 21.2495 8.4532 21.0895 8.3932C20.8795 8.3182 20.6695 8.2307 20.4745 8.1357C20.087 7.9432 19.722 7.7132 19.392 7.4582C17.442 5.9457 16.6795 2.7982 17.8195 0.980705C17.972 0.738205 17.9445 0.423204 17.752 0.210705C17.607 0.0507046 17.397 -0.0217953 17.192 0.00570486ZM11.522 1.2807C11.377 1.2782 11.2295 1.3257 11.1095 1.4257C10.142 2.2132 9.15201 3.5032 9.10951 3.55571C9.10452 3.56571 9.09951 3.5732 9.09201 3.5832C7.34201 6.1307 7.20951 9.7557 8.75701 12.8182C8.99951 13.3032 9.27452 13.7657 9.56701 14.1907L9.65451 14.3157C9.90201 14.6782 10.1795 15.0882 10.5345 15.4082C10.657 15.5482 10.7895 15.6832 10.9195 15.8132L10.982 15.8782L11.0345 15.9307C11.167 16.0582 11.302 16.1882 11.442 16.3132H11.4445C11.4545 16.3282 11.4695 16.3382 11.482 16.3507C11.6395 16.4907 11.7995 16.6232 12.012 16.7907L12.0695 16.8332C12.2345 16.9657 12.402 17.0907 12.5745 17.2132C12.592 17.2257 12.6095 17.2382 12.627 17.2507C12.687 17.2907 12.747 17.3282 12.807 17.3707L12.867 17.4107L12.937 17.4557C13.0645 17.5407 13.1895 17.6182 13.367 17.7207C13.482 17.7907 13.6045 17.8607 13.6845 17.9007C13.7195 17.9207 13.757 17.9407 13.8445 17.9882L14.0395 18.0907C14.0495 18.0957 14.0945 18.1157 14.1045 18.1207C14.232 18.1857 14.3645 18.2482 14.497 18.3082L14.6995 18.3982C14.832 18.4557 14.967 18.5107 15.132 18.5732L15.207 18.6007C15.212 18.6057 15.2745 18.6282 15.2795 18.6307C15.3995 18.6732 15.522 18.7157 15.6445 18.7557L15.9245 18.8482C16.0645 18.8957 16.227 18.9507 16.4045 18.9807C17.277 19.1257 18.1245 19.2007 18.927 19.2007C19.022 19.2007 19.117 19.1982 19.2095 19.1982C26.2745 19.0432 28.112 13.0407 28.1295 12.9807C28.217 12.6782 28.0745 12.3557 27.7895 12.2207C27.5045 12.0857 27.1645 12.1807 26.987 12.4407C25.197 15.0557 21.812 16.1607 18.3645 15.2507C18.2045 15.2107 18.0495 15.1657 17.857 15.1032C17.8245 15.0932 17.797 15.0832 17.7445 15.0632C17.632 15.0282 17.522 14.9907 17.397 14.9432L17.2195 14.8757C17.117 14.8357 17.0145 14.7957 16.8895 14.7407L16.807 14.7032C16.6545 14.6382 16.507 14.5657 16.3745 14.5007L16.0095 14.3107C15.927 14.2707 15.8545 14.2257 15.742 14.1582L15.6795 14.1232L15.617 14.0857C15.5245 14.0307 15.432 13.9732 15.347 13.9132L15.287 13.8757C15.282 13.8732 15.232 13.8382 15.227 13.8332C15.152 13.7857 15.0795 13.7382 15.0095 13.6932C14.8545 13.5832 14.702 13.4682 14.5245 13.3282L14.4545 13.2707C12.8045 11.9532 11.5845 10.1932 11.012 8.30571C10.4795 6.5732 10.8745 4.3057 12.0695 2.2407C12.2245 1.9732 12.167 1.6332 11.9295 1.4332C11.812 1.3332 11.667 1.2807 11.522 1.2807ZM4.47952 3.2007C4.32701 3.2007 4.17202 3.25571 4.04951 3.36571C2.82702 4.4632 1.91202 5.8857 1.81202 6.0482C-0.802985 9.8557 -0.297985 15.7732 1.49701 19.3907C1.53202 19.4657 1.56951 19.5382 1.60702 19.6107L1.63202 19.6507C1.66452 19.7232 1.70202 19.7982 1.71452 19.8132C1.73452 19.8607 1.76452 19.9132 1.77702 19.9282C1.80702 19.9907 1.83702 20.0457 1.89202 20.1407L2.09702 20.4932C2.12702 20.5407 2.15702 20.5907 2.16702 20.6082C2.20702 20.6732 2.24951 20.7407 2.29202 20.8082L2.39202 20.9682C2.42202 21.0157 2.45202 21.0582 2.47202 21.0832C2.57202 21.2382 2.67202 21.3932 2.78202 21.5407C2.78701 21.5482 2.79202 21.5532 2.79701 21.5582L2.83701 21.6132C2.92702 21.7432 3.01951 21.8682 3.10202 21.9707L3.46702 22.4332C3.47202 22.4382 3.51202 22.4857 3.51451 22.4907L3.56701 22.5507C3.67702 22.6857 3.79452 22.8207 3.91202 22.9507C3.92952 22.9707 3.94701 22.9882 3.96451 23.0082C4.07701 23.1307 4.19202 23.2532 4.31202 23.3807L4.42701 23.4907C4.52202 23.5907 4.61701 23.6882 4.71701 23.7807C4.71701 23.7832 4.76451 23.8282 4.76451 23.8282L4.86451 23.9207C4.98452 24.0357 5.10951 24.1507 5.20451 24.2307C5.20951 24.2382 5.29951 24.3157 5.30701 24.3207C5.42451 24.4257 5.54202 24.5257 5.66202 24.6232L6.27451 25.1082C6.37701 25.1832 6.48202 25.2582 6.60202 25.3457C6.64202 25.3757 6.68451 25.4057 6.72701 25.4332C6.74451 25.4482 6.76451 25.4632 6.77701 25.4707L7.23701 25.7782C7.40451 25.8882 7.57201 25.9907 7.77701 26.1132L7.88701 26.1757C8.01451 26.2507 8.14452 26.3257 8.26701 26.3907C8.33951 26.4307 8.41201 26.4657 8.47451 26.4982C8.56201 26.5457 8.65701 26.5982 8.80201 26.6682C8.81451 26.6757 8.91702 26.7257 8.92951 26.7307C9.07452 26.8032 9.22201 26.8707 9.40701 26.9532C9.40701 26.9557 9.46701 26.9832 9.46701 26.9832C9.63701 27.0557 9.80202 27.1257 10.0195 27.2132C10.0545 27.2282 10.0895 27.2407 10.097 27.2432C10.252 27.3032 10.4145 27.3632 10.547 27.4107C10.5595 27.4157 10.627 27.4432 10.6395 27.4482C10.817 27.5082 10.992 27.5657 11.217 27.6357C11.2545 27.6482 11.2945 27.6607 11.2995 27.6607L11.427 27.7007C11.582 27.7482 11.737 27.7982 11.9045 27.8307C13.0945 28.0482 14.257 28.1607 15.357 28.1607H15.3595C24.527 28.1607 27.447 20.7832 27.477 20.7082C27.5895 20.4107 27.467 20.0757 27.187 19.9207C26.912 19.7682 26.562 19.8407 26.367 20.0932C24.0145 23.1907 19.577 24.3407 14.497 23.1732C14.3745 23.1432 14.2495 23.1082 14.127 23.0707L13.887 22.9982C13.7245 22.9482 13.562 22.8932 13.4045 22.8382C13.402 22.8382 13.3295 22.8107 13.3295 22.8107C13.1895 22.7632 13.0495 22.7082 12.927 22.6607L12.787 22.6057C12.632 22.5432 12.477 22.4782 12.327 22.4107L12.2395 22.3732C12.1045 22.3107 11.9745 22.2507 11.8445 22.1857C11.8345 22.1807 11.732 22.1307 11.722 22.1282C11.632 22.0832 11.542 22.0357 11.427 21.9732L10.9045 21.6932C10.852 21.6582 10.797 21.6257 10.7445 21.5982C10.587 21.5007 10.4245 21.4032 10.2645 21.3007C10.227 21.2782 10.1945 21.2532 10.132 21.2107C10.022 21.1407 9.91451 21.0682 9.75701 20.9582L9.69451 20.9132C9.58701 20.8382 9.48201 20.7582 9.39451 20.6932C9.33951 20.6532 9.28451 20.6082 9.19451 20.5407C9.11451 20.4782 9.03451 20.4182 8.95951 20.3582L8.81951 20.2432C8.70201 20.1482 8.59202 20.0482 8.47701 19.9507C8.46202 19.9357 8.44951 19.9257 8.43201 19.9132C8.30451 19.7957 8.17451 19.6782 8.01952 19.5307L7.56701 19.0807C7.45701 18.9682 7.34701 18.8532 7.22202 18.7157C7.10702 18.5882 6.99701 18.4607 6.84951 18.2857L6.57951 17.9557C6.54701 17.9082 6.51202 17.8607 6.46951 17.8107C6.37701 17.6857 6.28451 17.5632 6.19202 17.4332C3.70202 14.0032 3.05202 6.8432 4.99202 4.2207C5.18702 3.9582 5.15202 3.58821 4.90701 3.36571C4.78701 3.25571 4.63202 3.2007 4.47952 3.2007Z' fill='currentColor')
          div.one-row-icon(v-else :style='{color: row.color}')
            fa(:icon='row.icon' size='lg')

      //todo-crutch @mouseleave="onBtnLeave" в .buttons чтоб немерцали эффекты наведения когда курсор гуляет по кнопкам
      .buttons(
        :style="{gridTemplateRows: ' 1fr'.repeat(data.rows.length), gridTemplateColumns: ' 1fr'.repeat(data.cols.length)}"
        @mouseleave="onBtnLeave")
        template(v-for="(row, i) in data.items")
          button(
            v-for="(item, j) in row"
            :class="{'end-row': i === data.items.length - 1, 'end-col': j === row.length - 1, 'hover-row': curBtnHover.row === i && curBtnHover.col > j, 'hover-col': curBtnHover.col === j && curBtnHover.row > i}"
            @mouseenter="onBtnHover(i, j)"
          )
            span.button-circle


</template>

<script>

import $ from 'jquery';

import MegaMenu from './MegaMenu';

export default {
  name: 'GridMenu',

  components: {
    MegaMenu
  },

  props: {
    data: {
      type: Object,
      required: true
    },
    //options
    headerFreeSpaceShift: {
      type: Number,
      default: 25
    },
    headerColGapLines: {
      type: Number,
      default: 10
    }
  },

  data() {
    return {
      headerLines: [],
      curBtnHover: {row: null, col: null}
    }
  },

  mounted () {
    this.headerLines = this.calculatePositionHeaderLines();
  },

  computed: {

  },

  methods: {
    /**
     * Подсчёт отступов и высоты для линий идущих от заголовков в хедере
     * @returns {[]}
     */
    calculatePositionHeaderLines() {
      let lines = [];

      let $columns = $('.column', this.$refs.container);
      let width = $('.header', this.$refs.container).width();
      let outerHeight = $('.header', this.$refs.container).outerHeight();
      let paddingLeft = parseInt($('.header', this.$refs.container).css('padding-left'));

      this.data.cols.forEach((col, i, cols) => {
        let $col = $columns.eq(i);
        lines.push(
          {
            //todo-hack position несчитает margin-top
            t: parseInt($col.css('margin-top')) + $col.position().top + $col.outerHeight(),
            l: paddingLeft + ((width - this.headerColGapLines * (cols.length - 1)) / cols.length) * (i + 0.5) + this.headerColGapLines * i,
            h: outerHeight - (parseInt($col.css('margin-top')) + $col.position().top + $col.outerHeight())
          }
        );
      });

      return lines;
    },

    /**
     * Запись строки и колонки наведённой кнопки
     * @param {Number} i - строка
     * @param {Number} j - колонка
     */
    onBtnHover(i, j) {
      this.curBtnHover.row = i;
      this.curBtnHover.col = j;
    },

    onBtnLeave() {
      this.curBtnHover.row = null;
      this.curBtnHover.col = null;
    }
  },

  watch: {

  }
}
</script>

<style lang="scss" scoped>
  .grid-menu {
    padding-left: 6px;
    padding-right: 6px;
  }

  .header {
    padding-left: 60px;
    padding-bottom: 20px;
    position: relative;
  }

  .column {
    position: relative;
    margin-top: 5px;
    padding-left: 5px;
    padding-right: 5px;
    height: 23px;
    font-size: 14px;
    text-align: center;
    font-weight: bold;
    background-color: #fff;
    border: 1px solid #999;
    border-radius: 3px;
    z-index: 1;
    transition: border-color 0.2s ease-in-out;
  }

  .column.hover-col {
    border-width: 2px;
    border-color: #000;
    line-height: 19px;
  }

  .line {
    position: absolute;
    border-left: 1px solid #999;
    transition: border-color 0.2s ease-in-out;
  }

  .line.hover-col {
    border-left-color: #000;
  }

  .rows-buttons {
    display: flex;
  }

  .one-row {
    position: relative;
  }

  .one-row:after {
    content: "";
    position: absolute;
    top: 50%;
    left: 100%;
    width: 20px;
    border-top: 1px solid #999;
    transition: border-color 0.2s ease-in-out;
  }

  .one-row.hover-row:after {
    border-top-color: #000;
  }

  .one-row-icon {
    padding: 0;
    outline: none;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    font-size: 16px;
    border: 1px solid #999;
    background-color: #fff;
    border-radius: 3px;
    transition: border-color 0.2s ease-in-out;
  }

  .one-row:nth-child(n + 2) .one-row-icon {
    margin-top: 20px;
  }

  .one-row .fa-vuejs {
    font-size: 26px;
  }

  .one-row.hover-row .one-row-icon {
    border-width: 2px;
    border-color: #000;
  }

  $buttons-row-gap: 20px;
  $buttons-column-gap: 10px;
  $button-border-width: 1px;
  .buttons {
    margin-left: 20px;
    display: grid;
    flex-grow: 1;
    flex-basis: 0;
    row-gap: $buttons-row-gap;
    column-gap: $buttons-column-gap;

    button {
      position: relative;
      display: block;
      border: 1px solid #ccc;
      border-radius: 3px;
      outline: none;
      background: transparent;
    }

    button:before {
      content: '';
      margin-left: 1px;
      position: absolute;
      top: 50%;
      left: 100%;
      right: -$buttons-column-gap;
      border-top: 1px solid #ccc;
      transition: border-color 0.2s ease-in-out;
    }

    button.end-col:before {
      right: 50%;
    }

    button.hover-row:before {
      border-top-color: #000;
    }

    button:after {
      content: '';
      position: absolute;
      top: 100%;
      left: 50%;
      bottom: -$buttons-row-gap;
      border-left: 1px solid #ccc;
      transition: border-color 0.2s ease-in-out;
    }

    button.end-row:after {
      bottom: 50%;
    }

    button.hover-col:after {
      border-left-color: #000;
    }

    .button-circle {
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    .button-circle:before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background-color: #ccc;
      transform: translate(-50%, -50%);
      z-index: 1;
      transition: width 0.3s ease-in-out, height 0.3s ease-in-out;
    }

    /*.button-circle:after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      margin-top: -4px;
      margin-left: -4px;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: #999;
      z-index: 1;
      transition: transform 0.3s ease-in-out;
    }*/

    button:hover .button-circle:before {
      width: 100px;
      height: 100px;
    }
  }
</style>

<style lang="scss">

</style>