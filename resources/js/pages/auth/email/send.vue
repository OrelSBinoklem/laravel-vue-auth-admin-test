<template>
    <div class="row">
        <div class="col-lg-8 m-auto">
            <card :title="$t('verify_email')">
                <div v-if="resended === true" class="alert alert-success" role="alert">
                    {{ $t('fresh_verification_link') }}
                </div>
                <div v-if="resended === false" class="alert alert-danger" role="alert">
                    {{ $t('error_fresh_verification_link') }}
                </div>
                {{ $t('check_your_email') }}
                {{ $t('not_email') }}
                <div class="form-group row mt-3 justify-content-center">
                    <div class="col-auto">
                        <!-- Resend action Button -->
                        <v-button @press="resend" :loading="resendProcessed" native-type="button">
                            {{ $t('email_resend_link') }}
                        </v-button>
                    </div>
                </div>
            </card>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        middleware: ['auth', 'not-verified'],

        metaInfo () {
            return { title: this.$t('verify_email') }
        },

        data: () => ({
            resendProcessed: false,
            resended: null
        }),

        methods: {
            async resend () {
                this.resendProcessed = true
                // Resend letter
                const { data } = await axios.post(`/api/email/resend`)

                this.resended = data.resended === true;

                this.resendProcessed = false
            }
        }
    }
</script>
