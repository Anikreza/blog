<template>

    <ValidationObserver ref="observer" v-slot="{ invalid, validated, handleSubmit, validate }">

        <div class="mb-3">
            <label for="name" class="form-label">Dein Name</label>
            <ValidationProvider name="Name" rules="required" v-slot="{ errors, valid}">
                <input type="text"
                       id="name"
                       v-model="form.name"
                       class="form-control"
                       title="name">
                <span v-if="errors.length" class="text-danger">*{{ errors[0] }}</span>
            </ValidationProvider>
        </div>
        <div class="mb-3">
            <label for="E-Mail-Adresse" class="form-label">Deine E-Mail-Adresse</label>
            <ValidationProvider name="E-Mail-Adresse" rules="required|email" v-slot="{ errors, valid}">
                <input type="email"
                       v-model="form.email"
                       id="E-Mail-Adresse"
                       class="form-control"
                       title="email">
                <span v-if="errors.length" class="text-danger">*{{ errors[0] }}</span>
            </ValidationProvider>
        </div>
        <div class="mb-3">
            <label for="Betreff" class="form-label">Betreff</label>
            <ValidationProvider name="Betreff" rules="required" v-slot="{ errors, valid}">
                <input type="text"
                       v-model="form.subject"
                       id="Betreff"
                       class="form-control"
                       title="name">
                <span v-if="errors.length" class="text-danger">*{{ errors[0] }}</span>
            </ValidationProvider>
        </div>
        <div class="mb-3">
            <label for="Nachricht" class="form-label">Deine Nachricht</label>
            <ValidationProvider name="Nachricht" rules="required" v-slot="{ errors, valid}">
                <textarea name="message"
                          v-model="form.message"
                          class="form-control"
                          id="Nachricht"
                          title="message"
                          cols="30"
                          rows="7"></textarea>
                <span v-if="errors.length" class="text-danger">*{{ errors[0] }}</span>
            </ValidationProvider>
        </div>

        <div class="mb-3" v-if="success">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Vielen Dank für Ihre Kontaktaufnahme. Wir werden uns bald bei Ihnen melden.

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        @click="success=false"></button>
            </div>
        </div>
        <div class="mb-3" v-if="error">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Etwas ist schief gelaufen.

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        @click="error=false"></button>
            </div>
        </div>
        <button type="submit" class="mx-auto btn btn-primary" @click="handleSubmit(save)" :disabled="loading">
            {{ loading ? 'Submitting...' : 'Submit' }}
        </button>

    </ValidationObserver>
</template>

<script>
import {ValidationObserver, ValidationProvider} from 'vee-validate'

export default {
    components: {
        ValidationObserver, ValidationProvider
    },
    data() {
        return {
            loading: false,
            success: false,
            error: false,
            form: {
                name: null,
                email: null,
                subject: null,
                message: null
            }
        }
    },
    mounted() {
    },
    methods: {
        reset() {
            this.form = {
                name: null,
                email: null,
                subject: null,
                message: null
            }
            this.$refs.observer.reset();
        },
        save() {
            this.loading = true;

            this.$http.post('/api/v1/send-mail', this.form).then(res => {
                this.loading = false;
                this.success = true;
                this.reset();
            }).catch(err => {
                console.log(err)
                this.loading = false;
                this.error = true;
            })
        }
    }
}
</script>
