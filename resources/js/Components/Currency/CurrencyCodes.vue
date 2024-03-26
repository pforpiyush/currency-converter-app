<template>
    <div>
        <button class="btn btn-primary btn-md m-1" v-for="code in currencyStore.currencyCodes"
        :key="code['code']"
        @click="currencyStore.selectCurrency(code)">
            {{ code['name'] }} ({{ code['code'] }})
        </button>
        &nbsp;
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import { useCurrencyStore } from '@/Stores/CurrencyStore'

    const props = defineProps({
        allCodes : Object
    });

    const currencyStore = useCurrencyStore();

    onMounted(() => {
        currencyStore.setCurrencyCodes(JSON.parse(props.allCodes))
    });
</script>