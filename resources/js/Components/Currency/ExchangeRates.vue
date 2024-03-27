<template>
    <div v-if="currencyStore.error" class="alert alert-danger alert-dismissible text-center" role="alert">
        {{ currencyStore.error }}
    </div>
    <div class="span2">
        <button class="btn btn-dark m-3" @click="currencyStore.exchangeCurrency()">Get latest exchange rates</button>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
    <div v-if="currencyStore.exchangeRates">
        <div class="row justify-content-center">
        <!-- This can be made into a child table component of its own -->
        <table class="table table-striped mb-0 w-auto">
            <thead>
                <tr>
                    <th>Currency Code</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(currency, code) in currencyStore.exchangeRates" :key="currency">
                    <td>{{ code }}</td>
                    <td>{{ parseFloat(currency).toFixed(2) }}</td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
</template>

<script setup>
    import { useCurrencyStore } from '@/Stores/CurrencyStore'

    const currencyStore = useCurrencyStore()
</script>