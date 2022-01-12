import { configure, extend } from 'vee-validate'
import { confirmed, email, image, min, required, size } from 'vee-validate/dist/rules'
import i18n from '@/i18n'

configure({
  defaultMessage: (field, values) => {
    values._field_ = i18n.t(`Fields.${field}`)
    return i18n.t(`validation.${values._rule_}`, values)
  }
})

extend('required', required)
extend('email', email)
extend('min', min)
extend('image', image)
extend('size', size)
extend('confirmed', confirmed)
