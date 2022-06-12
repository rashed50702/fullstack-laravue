import './bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

//iviewui
import ViewUIPlus from 'view-ui-plus'
import 'view-ui-plus/dist/styles/viewuiplus.css'


let app=createApp(App)
app.use(router)
app.use(ViewUIPlus)
app.mount("#app")