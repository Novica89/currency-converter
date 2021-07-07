<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Currency converter component</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" id="currencyFromAmount" v-model="currencyFromAmount" @input="convertCurrencies()" placeholder="amount...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select id="currencyFrom" class="form-control" @change="convertCurrencies()" v-model="currencyFrom">
                                            <option value="default">Convert from...</option>
                                            <option v-for="currency in supportedCurrencies" :value="currency">{{ currency }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" id="currencyToAmount" v-model="currencyToAmount" @input="convertCurrencies('to')" placeholder="amount...">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select id="currencyTo" class="form-control" @change="convertCurrencies()" v-model="currencyTo">
                                            <option value="default">Convert to...</option>
                                            <option  v-for="currency in supportedCurrencies" :value="currency">{{ currency }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                supportedCurrencies: ['USD', 'EUR', 'AUD'],
                conversionRates: [],
                currencyFrom: 'EUR',
                currencyTo: 'USD',
                currencyFromAmount: '',
                currencyToAmount: '',
                conversionResult: false,
                apiUrl: this.$root.$options.AppConfig.apiUrl
            }
        },

        methods:  {
            convertCurrencies: function(direction = 'from') {
                if(this.currencyFrom === 'default' || this.currencyTo === 'default') {
                    return;
                }

                if(direction === 'from') {
                    this.conversionResult = this.conversionRates[this.currencyFrom][this.currencyTo][0]['conversion_rate'] * this.currencyFromAmount;
                    this.currencyToAmount = parseFloat(this.conversionResult).toFixed(2);
                } else {
                    this.conversionResult = this.conversionRates[this.currencyTo][this.currencyFrom][0]['conversion_rate'] * this.currencyToAmount;
                    this.currencyFromAmount = parseFloat(this.conversionResult).toFixed(2);
                }
            }
        },

        mounted() {
            // here, make a backend call to populate the supported currency conversion pairs and populate the data property with it
            // doing it this way allows for instant currency conversions in the client without the need to do constant backend API calls
            axios.get(this.apiUrl + 'conversionRates')
                .then(response => {
                    this.supportedCurrencies = response.data.currencies;
                    this.conversionRates = response.data.rates;
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => console.log('all done'))
        },

        watch: {
            currencyFromAmount: function(val, oldVal) {
                // we can do a check here on val and if it's nothing, set the value to 0 if required
            }
        }
    }
</script>
