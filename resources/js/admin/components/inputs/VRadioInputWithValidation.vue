<template>
    <ValidationProvider :name="field" :rules="rules" v-slot="{ errors, valid}">
        <v-radio-group :row="isRow"
                       v-model="inner_value"
                       v-bind="$attrs"
                       v-on="$listeners">
            <template v-slot:label>
                <div>{{ $t('Fields.' + field) }}:</div>
            </template>
            <v-radio v-for="(option, i) in options" :key="i"
                     :label="option.label"
                     :disabled="disabled"
                     :name="option.label"
                     :value="option.value"
            />
        </v-radio-group>
    </ValidationProvider>
</template>

<script>
import {ValidationProvider} from 'vee-validate'

export default {
    components: {
        ValidationProvider
    },
    props: {
        rules: {
            type: [Object, String],
            default: ''
        },
        disabled: {
            type: Boolean,
            default: false
        },
        value: {
            required: true
        },
        field: {
            type: String,
            required: true
        },
        isRow: {
            type: Boolean,
            default: true
        },
        options: {
            type: Array,
            required: true
        }
    },
    data: () => {
        return {
            inner_value: '',
        }
    },
    async created() {
        this.inner_value = this.value
    },
    watch: {
        // Handles internal model changes.
        inner_value(newVal) {
            this.$emit('input', newVal)
        },
        // Handles external model changes.
        value(newVal) {
            this.inner_value = newVal
        }
    },
}
</script>
