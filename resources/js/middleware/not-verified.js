import store from '~/store'

export default async (to, from, next) => {
    if (!store.getters['auth/check']) {
        next()
    } else {
        if(store.getters['auth/checkVerified'] === false) {
            next()
        } else {
            next({ name: 'home'})
        }
    }
}
