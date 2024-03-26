import './bootstrap';
import '../css/app.css';

// Currency Exchange components
import CurrencyCodes from './Components/Currency/CurrencyCodes.vue';
import SelectedCurrencies from './Components/Currency/SelectedCurrencies.vue';
import ExchangeRates from './Components/Currency/ExchangeRates.vue';

// History rates components
import HistoryForm from './Components/HistoryRate/HistoryForm.vue';
import HistoryList from './Components/HistoryRate/HistoryList.vue';

import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

const currencyApp = createApp({});
const pinia = createPinia();
currencyApp.component('currency-codes', CurrencyCodes);
currencyApp.component('selected-currencies', SelectedCurrencies);
currencyApp.component('exchange-rates', ExchangeRates);
currencyApp.use(pinia);
currencyApp.mount('#currency-app');

const historyApp = createApp({});
historyApp.component('history-form', HistoryForm);
historyApp.component('history-list', HistoryList);
historyApp.mount('#history');