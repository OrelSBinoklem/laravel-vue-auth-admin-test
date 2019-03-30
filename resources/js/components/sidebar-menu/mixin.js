export const itemMixin = {
    data() {
        return {
            active: false,
            childActive: false
        }
    },
    created() {
        this.active = this.item && this.item.href ? this.isLinkActive(this.item) : false
        this.childActive = this.item && this.item.child ? this.isChildActive(this.item.child) : false
        this.show = this.item && this.item.child ? this.isChildActive(this.item.child) : false
    },
    methods: {
        toggleDropdown() {
            this.show = !this.show
        },
        isLinkActive(item) {
            if ( this.$route ) {
                if(this.$route.name && item.href.name) {
                  return this.$route.name.indexOf(item.href.name) === 0
                } else {
                  return this.$route.path.indexOf(item.href) === 0
                }
            } else {
                return window.location.pathname.indexOf(item.href) === 0
            }
        },
        isChildActive(child) {
            for (let item of child) {
                if (this.isLinkActive(item)) {
                    return true
                }
                if (item.child) {
                    if ( this.isChildActive(item.child) ) {
                        return true
                    }
                }
            }
            return false
        }
    },
    computed: {
        isRouterLink() {
            return this.$router && this.item && this.item.href !== undefined
        }
    },
    watch: {
        $route() {
            this.active = this.item && this.item.href ? this.isLinkActive(this.item) : false
            this.childActive = this.item && this.item.child ? this.isChildActive(this.item.child) : false
        }
    },
}