<template>
    <div class="vsm-item mobile-item" v-if="item" :class="[{'open-item' : item.child}, {'active-item' : active}, {'parent-active-item' : childActive}]">
        <template v-if="!item.child">
            <router-link class="vsm-link" v-if="isRouterLink" :to="item.href">
                {{item.title.translate ? $t(item.title.translate) : item.title}}
            </router-link>
            <a class="vsm-link" v-else :href="item.href">
                {{item.title.translate ? $t(item.title.translate) : item.title}}
            </a>
        </template>
        <template v-else>
            <div class="vsm-link">
                {{item.title.translate ? $t(item.title.translate) : item.title}}
                <i class="vsm-arrow open-arrow"><fa icon="angle-right" fixed-width/></i>
            </div>
        </template>
    </div>
</template>

<script>
import {itemMixin} from './mixin'

export default {
    props: {
        item: {
            type: Object,
        },
    },
    mixins: [itemMixin],
    watch: {
        item() {
            this.active = this.item && this.item.href ? this.isLinkActive(this.item) : false
            this.childActive = this.item && this.item.child ? this.isChildActive(this.item.child) : false
        }
    }
}
</script>