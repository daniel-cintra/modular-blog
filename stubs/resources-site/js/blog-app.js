import { createApp } from 'vue/dist/vue.esm-bundler.js'
import BlogToolbar from './Components/Blog/BlogToolbar.vue'

//for static images
import.meta.glob(['../images/**'])

createApp({
    name: 'BlogApp',
    components: {
        BlogToolbar
    }
}).mount('#app')
