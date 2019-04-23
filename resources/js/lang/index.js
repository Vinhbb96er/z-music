import Vue from 'vue'
import VueI18n from 'vue-i18n'
import vnMessage from './vn.json'
import enMessage from './en.json'

Vue.use(VueI18n)

const messages = {
  vn: vnMessage,
  en: enMessage
};

export const i18n = new VueI18n({
  locale: window.Laravel.locale,
  messages,
  fallbackLocale: 'vn',
})
