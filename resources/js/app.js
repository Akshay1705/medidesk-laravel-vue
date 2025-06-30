import '../css/app.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

// ✅ Import Toast plugin
import Toast from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

// ✅ App name fallback
const appName = import.meta.env.VITE_APP_NAME || 'MediDesk'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) })

        // ✅ Register plugins
        vueApp
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, {
                autoClose: 3000,
                position: 'top-right',
                pauseOnHover: true,
                theme: 'light',
            })

        vueApp.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
