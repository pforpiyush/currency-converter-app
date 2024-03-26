<template>
    <div id="selected-currencies" ref="selectedCurrencies">
        <button class="btn btn-secondary btn-md m-1" v-for="code in currencyStore.selectedCodes"
        :key="code['code']"
        @click="currencyStore.removeCurrency(code)">
            {{ code['name'] }} ({{ code['code'] }})
        </button>
        &nbsp;
    </div>
</template>

<script setup>
    import { useCurrencyStore } from '@/Stores/CurrencyStore'

    const currencyStore = useCurrencyStore()
</script>
