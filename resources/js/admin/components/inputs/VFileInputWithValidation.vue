<template>
    <ValidationProvider :name="field" :rules="rules" v-slot="{ errors }">
        <v-row style="margin-left: 0; margin-right: 0">
            <v-flex :class="[(isRow || multiple) ? 'xs12 md12' : 'xs12 md8' ]">
                <v-file-input :prepend-icon="prependIcon"
                              v-model="inner_value"
                              :label="$t('Fields.'+field)"
                              :error-messages="errors"
                              v-bind="$attrs"
                              v-on="$listeners"
                              id="file-input"
                              clearable
                              show-size
                              outlined
                              counter
                              chips
                              @change="handleFileSelection"
                              @click:clear="resetImage"
                              :multiple="multiple"
                />
            </v-flex>
            <v-flex :class="[(isRow || multiple) ? 'xs12 md12' : 'xs12 md4' ]" class="file-preview-wrapper"
                    id="file-preview-area">
                <div v-if="multiple" class="image-list">
                    <img v-for="(imgLink, i) in imageSrc" :src="imgLink" :key="i" :class="imgClass" alt=""/>
                </div>
                <div v-else>
                    <img :src="imageSrc" alt="" :class="imgClass"/>
                </div>
            </v-flex>
        </v-row>
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
        imageUrl: {
            type: null,
            required: false
        },
        field: {
            type: String,
            required: true
        },
        isRow: {
            type: Boolean,
            default: false
        },
        prependIcon: {
            type: String,
            default: 'mdi-camera'
        },
        imgClass: {
            type: String,
            default: 'img-center'
        },
        multiple: {
            type: Boolean,
            default: false
        }
    },
    data: () => {
        return {
            inner_value: null,
            selectedImageUrl: null
        }
    },
    computed: {
        imageSrc() {
            if (this.selectedImageUrl) {
                return this.selectedImageUrl
            } else if (this.imageUrl) {
                return this.imageUrl
            } else {
                return this.multiple ? [require('@/assets/img/no-image.jpg')] : require('@/assets/img/no-image.jpg')
            }
        }
    },
    async created() {
        if (this.value) {
            this.inner_value = this.multiple ? this.value : [this.value]
        }
    },
    methods: {
        async handleFileSelection() {
            if (!this.inner_value.length) return

            if (this.multiple) {
                this.selectedImageUrl = []

                for (let i in this.inner_value) {
                    await this.generateBlobFileUrls(this.inner_value[+i])
                }
            } else {
                await this.generateBlobFileUrls(this.inner_value[0])
            }
        },
        async generateBlobFileUrls(val) {
            const reader = new FileReader()
            reader.readAsDataURL(val)
            reader.onload = async e => {
                this.multiple ? this.selectedImageUrl.push(e.target.result) : (this.selectedImageUrl = e.target.result)
            }
        },
        resetImage() {
            this.selectedImageUrl = null
            if (this.imageUrl) {
                return this.imageUrl
            } else {
                return require('@/assets/img/no-image.jpg')
            }
        }
    },
    watch: {
        // Handles internal model changes.
        inner_value(newVal) {
            this.$emit('input', this.multiple ? newVal : newVal[0])
        },
        // Handles external model changes.
        value(newVal) {
            this.inner_value = this.multiple ? newVal : [newVal]
        }
    },
}
</script>
