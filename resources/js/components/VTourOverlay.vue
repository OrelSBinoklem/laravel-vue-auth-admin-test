<template>
  <div class="v-tour-overlay">
    <div v-if="showTourBg" class="v-tour-bg">
      <div class="v-tour-bg-el v-tour-bg-top" :style="{bottom: (tourStepPos.wh - tourStepPos.t) + 'px'}"></div>
      <div class="v-tour-bg-el v-tour-bg-left" :style="{top: (tourStepPos.t) + 'px', bottom: (tourStepPos.wh - tourStepPos.t - tourStepPos.elh) + 'px', right: (tourStepPos.ww - tourStepPos.l) + 'px'}"></div>
      <div class="v-tour-bg-el v-tour-bg-right" :style="{top: (tourStepPos.t) + 'px', bottom: (tourStepPos.wh - tourStepPos.t - tourStepPos.elh) + 'px', left: (tourStepPos.l + tourStepPos.elw) + 'px'}"></div>
      <div class="v-tour-bg-el v-tour-bg-bottom" :style="{top: (tourStepPos.t + tourStepPos.elh) + 'px'}"></div>
    </div>

    <v-tour :name="name" :steps="steps" :callbacks="myCallbacks">
      <template slot-scope="tour">
        <transition name="fade">
          <template>
            <v-step
              v-if="tour.currentStep === index"
              v-for="(step, index) of tour.steps"
              :key="index"
              :step="step"
              :previous-step="tour.previousStep"
              :next-step="tour.nextStep"
              :stop="tour.stop"
              :is-first="tour.isFirst"
              :is-last="tour.isLast"
              :labels="tour.labels"
            >
              <template>
                <div slot="actions">
                  <button @click.prevent="showTourBg = false; onStop(tour.currentStep); tour.stop()" v-if="!tour.isLast" class="v-step__button">{{ tour.labels.buttonSkip }}</button>
                  <button @click.prevent="tourChange(tour.currentStep - 1); onPreviousStep(tour.currentStep - 1); tour.previousStep()" v-if="!tour.isFirst" class="v-step__button">{{ tour.labels.buttonPrevious }}</button>
                  <button @click.prevent="tourChange(tour.currentStep + 1); onNextStep(tour.currentStep + 1); tour.nextStep()" v-if="!tour.isLast" class="v-step__button">{{ tour.labels.buttonNext }}</button>
                  <button @click.prevent="showTourBg = false; onStop(tour.currentStep); tour.stop()" v-if="tour.isLast" class="v-step__button">{{ tour.labels.buttonStop }}</button>
                </div>
              </template>
            </v-step>
          </template>
        </transition>
      </template>
    </v-tour>
  </div>
</template>

<script>

export default {
  name: 'v-tour-overlay',
  props: {
    steps: {
      type: Array,
      default: () => []
    },
    name: {
      type: String
    }
  },
  data () {
    return {
      showTourBg: false,

      currentTourStep: 0,

      tourStepPos: {
        t: 0,
        l: 0,
        elw: 0,
        elh: 0,
        ww: 0,
        wh: 0
      },

      myCallbacks: {
        onStart: function() {},
      }
    }
  },
  beforeMount () {
    this.myCallbacks.onStart = this.onStart
  },

  mounted () {

  },
  beforeDestroy () {

  },
  computed: {

  },
  methods: {
    onStart (i) {
      this.$emit('start', this.currentTourStep);
      this.showTourBg = true;
      this.tourChange(0);
    },

    onPreviousStep (i) {
      this.$emit('previous-step', i);
    },

    onNextStep (i) {
      this.$emit('next-step', i);
    },

    onStop (i) {
      this.$emit('stop', i);
    },

    tourChange(currentStep) {
      this.currentTourStep = currentStep
      this.$nextTick(() => {
        this.tourStepRefreshBg();
      })
    },

    tourStepRefreshBg() {
      let step = this.steps[this.currentTourStep]
      let $el = $(step.target);
      this.tourStepPos.t = $el.offset().top - $(window).scrollTop()
      this.tourStepPos.l = $el.offset().left - $(window).scrollLeft()
      this.tourStepPos.elw = $el.outerWidth()
      this.tourStepPos.elh = $el.outerHeight()
      this.tourStepPos.ww = $(window).width()
      this.tourStepPos.wh = $(window).height()
    }
  },
}
</script>

<style lang="scss" scoped>
  .v-tour-bg-el {
    position: fixed;
    z-index: 19;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .v-tour-bg-top {
    top: 0;
    left: 0;
    right: 0;
  }

  .v-tour-bg-left {
    left: 0;
  }

  .v-tour-bg-right {
    right: 0;
  }

  .v-tour-bg-bottom {
    left: 0;
    right: 0;
    bottom: 0;
  }
</style>