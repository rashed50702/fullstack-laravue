import './bootstrap';
import { createApp } from 'vue'
import maincomponent from "./components/Main.vue";
import router from './router'
import store from './store'

//iviewui
import ViewUIPlus from 'view-ui-plus'
import 'view-ui-plus/dist/styles/viewuiplus.css'
import locale from 'view-ui-plus/dist/locale/en-US';







import common from './common'


// let app=createApp(App)
// app.use(router)
// app.component('main-component', Main)
// app.use(store)
// app.use(ViewUIPlus,{locale})
// app.mixin(common)
// app.mount("#app")
const app = createApp({})

app.component('main-component', maincomponent)
app.use(router)
app.use(store)
app.use(ViewUIPlus, { locale })
app.mixin(common)
app.mount('#app')

// const app = createApp({
//     components: {
//         Main
//     }
// });

// app.use(router)
// app.use(store)
// app.use(ViewUIPlus, { locale })
// app.mixin(common)
// app.mount("#app");
