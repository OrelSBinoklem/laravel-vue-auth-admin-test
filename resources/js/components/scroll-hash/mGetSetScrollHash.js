import $ from 'jquery'

export const mGetSetScrollHash = {
  data: () => ({
    currentHashScrolled: '',
    currentHash: ''
  }),

  methods: {
    gotoHash(hash) {
      this.$router.push({ hash: (!!hash ? '#' : '') + hash })
    },

    detectHash() {
      //todo-hack убрать +1
      let posTop = null;
      let hash = null;

      let scrollTop = $(window).scrollTop();
      let windowHeight = $(window).height();

      $('.is-hash[id]').each(function () {

        if(
          $(this).offset().top + 1 > scrollTop
          && $(this).offset().top + 1 < scrollTop + windowHeight
          && posTop === null || $(this).offset().top + 1 < posTop
        ) {
          posTop = $(this).offset().top + 1;
          hash = $(this).attr('id');
        }

      });

      if(hash !== null && hash !== this.currentHashScrolled)
        this.currentHashScrolled = hash;
    },

    updateCurrentHash(hash) {
      this.currentHash = hash;
      this.gotoHash(hash);
    },


  },

  watch: {
    '$route.hash': function (hash) {
      if(hash.substr(1) !== this.currentHash) {
        this.currentHashScrolled = this.currentHash = hash.substr(1);
      }
    }
  },

  beforeMount: function () {
    window.addEventListener('scroll', this.detectHash);
    window.addEventListener('resize', this.detectHash);
    this.$nextTick(() => {
      this.detectHash();
    });
  },

  beforeDestroy: function () {
    window.removeEventListener('scroll', this.detectHash);
    window.removeEventListener('resize', this.detectHash);
  }
};