<template>
    <div class="row justify-content-center">
        <table class="table table-striped mb-0 w-auto">
            <thead>
                <tr>
                    <th>Echange Date</th>
                    <th>Exchange Rate</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="currency in currencies" :key="currency">
                    <td>{{ currency['exchange_date'] }}</td>
                    <td>{{ currency['value'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'CurrenciesList',
    props: {
        currencies: Object
    }
}
</script>