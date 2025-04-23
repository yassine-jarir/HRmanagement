import './scss/main.scss'
import { createApp } from 'vue'
import { createVuestic } from 'vuestic-ui'
import App from './App.vue'
import i18n from './i18n'
import stores from './stores'
import router from './router'
  
const app = createApp(App)

app.use(stores)
app.use(router)
app.use(i18n)
app.use(createVuestic())

app.mount('#app')
