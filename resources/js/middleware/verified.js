import store from '~/store'

export default async (to, from, next) => {
    if (!store.getters['auth/check'] || store.getters['auth/checkOAuth']) {
        next()
    } else {
        if(store.getters['auth/checkVerified']) {
            next()
        } else {
            next({name: 'email.resend'})
        }
    }
}
