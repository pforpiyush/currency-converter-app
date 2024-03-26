import { defineStore } from 'pinia';

export const useCurrencyStore = defineStore({
    id: 'currency',
    state: () => ({
        currencyCodes: [],
        selectedCodes: [],
        exchangeRates: null,
        error: null,
    }),
    getters: {
        getExchangeRates: (state) => {return state.ExchangeRates}
    },
    actions: {
        setCurrencyCodes(codes) {
            this.currencyCodes = codes;
        },
        selectCurrency(code) {
            if (5 == this.selectedCodes.length) {
                this.error = "Only upto five currencies can be selected";
                return;
            }
            this.error = null;
            this.currencyCodes.splice(this.currencyCodes.indexOf(code), 1);
            this.selectedCodes.push(code);
        },
        removeCurrency(code) {
            this.selectedCodes.splice(this.selectedCodes.indexOf(code), 1);
            this.currencyCodes.push(code);
        },
        async exchangeCurrency() {
            if (0 == this.selectedCodes.length) {
                this.error = "Please select atleast one currency code from the list";
                return;
            }

            var codes = this.selectedCodes.map(
                currency => currency.code
            );

            this.error = null;
            this.exchangeRates = null;

            await axios.post('/currencies', { selectedValue: codes.toString() })
            .then(response => {
                this.exchangeRates = response.data['data'];
            })
            .catch(error => {
                this.error = "Something went wrong when retriving exchange rates";
                console.error("There was an error: ", error.response);
            });
        }
    }
});