<template>
    <div v-if="error" class="col-md-4 alert alert-danger" role="alert">
        {{ error }}
    </div>
    <div class="container">
        <form @submit.prevent="submitForm">
        <div class="row">
            <!-- Simple dorpdown UI with limited currencies -->
            <select class="form-select" v-model="selectedValue">
                <option disabled value="">Please select one</option>
                <option value="GBP">GBP</option>
                <option value="AUD">AUD</option>
                <option value="JPY">JPY</option>
                <option value="INR">INR</option>
                <option value="EUR">EUR</option>
            </select>
        </div>
        <div class="row m-3 col-md-4 alert alert-primary justify-content-center">{{ selectedValue ? selectedValue : "Select a currency" }}</div>
        <!-- Interval selection radio buttons -->
        <h3>Select period of report</h3>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radio" value="monthly" v-model="intervalValue" checked />
                <label class="form-check-label" for="monthly">One year</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radio" value="weekly" v-model="intervalValue" />
                <label class="form-check-label" for="weekly">Six months</label>
            </div>
            <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radio" value="daily" v-model="intervalValue" />
                    <label class="form-check-label" for="daily">One month</label>
            </div>
        </div>
        
        <div>
            <button class="btn btn-success m-3" type="submit">Get exchange rates</button>
        </div>
        </form>
    </div>
    
    <ul v-if="responseMessage">
        <history-list :currencies="responseMessage"></history-list>
    </ul>
    <div v-if="batchId">
        Loading exchange rates: {{ progress }}%
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selectedValue: '',
                intervalValue: 'monthly',
                responseMessage: null,
                completeData: null,
                batchId: null,
                progress: 0,
                error: null,
            };
        },
        methods: {
            async submitForm(resubmission = false) {
                if ('' === this.selectedValue) {
                    this.error = "Please select a currency to continue";
                    return;
                }
                if (!resubmission) {
                    return;
                }
                this.error = null;
                this.responseMessage = null;
                await axios.post('/historical-rates', { currencyCode: this.selectedValue, intervalPeriod: this.intervalValue })
                .then(response => {
                    // If the data has "batch" key, then the batch is still in progress
                    // So get the batch progress to show it to user
                    if (response.data['batch'] !== undefined) {
                        this.batchId = response.data['batch']['id']
                        this.startRequesting()
                    } else {
                        this.responseMessage = response.data;
                        this.completeData = response.data;
                    }
                })
                .catch(error => {
                    this.error = "Something went wrong while getting historical rates";
                    console.error("There was an error: ", error.response.data.message);
                    this.clearRequestInterval();
                });
            },
            // All methods to get batch progress
            async fetchData() {
                try {
                    const response = await axios.get('/api/batch/'+this.batchId);
                    this.progress = response.data
                    // Batch has been completed, resubmit to get exchange rates
                    if (response.data == 100) {
                        this.clearRequestInterval(true);
                    }
                } catch (error) {
                    console.error('Error fetching data:', error);
                    this.error = "Something went wrong when getting historical rates";
                    this.clearRequestInterval();
                }
            },
            startRequesting() {
                this.requestInterval = setInterval(this.fetchData, 3000);
            },
            clearRequestInterval(resubmit = false) {
                if (this.requestInterval) {
                    clearInterval(this.requestInterval);
                    this.requestInterval = null;
                    this.batchId = null;
                    console.log('Interval cleared!');
                    // Call the submit form again to get the stored values from the database
                    if (resubmit) {
                        this.submitForm();
                    }
                }
            },
        },
        beforeDestroy() {
            // Clear the interval before the component gets destroyed as well
            this.clearRequestInterval();
        },
    }
</script>

<style>
.btn-success {
    color: #fff;
    background-color: #198754;
}
</style>