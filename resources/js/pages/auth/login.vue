<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('login')">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email"/>
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password"/>
            </div>
          </div>

          <!-- Check a robot -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('captcha') }}</label>
            <div class="col-md-7">
              <Recaptcha :sitekey="sitekey" :callback="onCaptcha"></Recaptcha>
              <span class="form-control is-invalid d-none"></span>
              <has-error :form="form" field="g-recaptcha-response"/>
            </div>
          </div>

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-3"/>
            <div class="col-md-7 d-flex">
              <checkbox v-model="remember" name="remember">
                {{ $t('remember_me') }}
              </checkbox>

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('login') }}
              </v-button>

              <!-- GitHub Login Button -->
              <login-with-github/>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import Recaptcha from '~/components/Recaptcha'

export default {
  middleware: 'guest',

  components: {
    Recaptcha,
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    recaptchaId: 0,
    sitekey: '6LeOy3gUAAAAAIfjc5xXKAmEOAcGgW_cDQXR2myE',
    form: new Form({
      email: '',
      password: '',
      'g-recaptcha-response': ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await new Promise((resolve, reject) => {
        this.form.post('/api/login')
          .then(response => {resolve(response)})
          .catch(error => {
            if (this.form['g-recaptcha-response'] != '') {
              this.form['g-recaptcha-response'] = ''
              window.grecaptcha.reset(this.recaptchaId)
            }
            reject(error)
          })
      })

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    },

    onCaptcha(token, recaptchaId) {
      this.form['g-recaptcha-response'] = token
      this.recaptchaId = recaptchaId
    }
  }
}
</script>
