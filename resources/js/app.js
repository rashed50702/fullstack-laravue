import './bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

//iviewui
import ViewUIPlus from 'view-ui-plus'
import 'view-ui-plus/dist/styles/viewuiplus.css'
import locale from 'view-ui-plus/dist/locale/en-US';




import common from './common'


let app=createApp(App)
app.use(router)
app.use(store)
app.use(ViewUIPlus,{locale})
app.mixin(common)
app.mount("#app")