<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('register')">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)" action="" method="post">

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name"/>
            </div>
          </div>

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

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation"/>
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

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('register') }}
              </v-button>

              <!-- GitHub Register Button -->
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
    return { title: this.$t('register') }
  },

  data: () => ({
    recaptchaId: 0,
    sitekey: '6LeOy3gUAAAAAIfjc5xXKAmEOAcGgW_cDQXR2myE',
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      'g-recaptcha-response': '',
      recaptcha_verified: false
    })
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await new Promise((resolve, reject) => {
        this.form.post('/api/register')
          .then(response => {resolve(response)})
          .catch(error => {
            if (this.form['g-recaptcha-response'] != '') {
              this.form['g-recaptcha-response'] = ''
              window.grecaptcha.reset(this.recaptchaId)
            }
            reject(error)
          })
      })
      this.form.recaptcha_verified = true;

      // Log in the user.
      const { data: { token } } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

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
