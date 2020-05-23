<template>
    <div>
        <div class="bg-gray-200">
            <div class="p-2 text-3xl">
                Activity Logs
            </div>
        </div>

        <div class="bg-yellow-200 p-2" v-if="fetching.underway && !fetching.completed">
            <i class="fas fa-spinner fa-spin"></i> Fetching records...
        </div>

        <div class="bg-red-500 p-2 text-white" v-if="fetching.failed">
            Error: Unable to fetch records.
        </div>

        <div class="bg-white" v-if="pagination">
            <div class="mt-2 container text-center mx-auto">
                <div class="inline" v-for="(pagination_elements_set, key) in pagination.pagination_elements">
                    <button @click.prevent="fetch(link)" class="inline border p-2" v-for="(link, page_number) in pagination_elements_set" v-if="!isString(pagination_elements_set)" v-text="page_number"></button>
                    <div class="inline p-2" v-if="isString(pagination_elements_set)" v-text="pagination_elements_set"></div>
                </div>
            </div>
        </div>

        <div class="headings mt-2">
            <div>ID</div>
            <div>Date</div>
            <div>Loan ID</div>
            <div>Subject</div>
            <div>Doer</div>
            <div>Activity</div>
            <div>Details</div>
            <div>IP Address</div>
        </div>

        <div v-for="(account_record_sets, account_id) in records">

            <div v-for="(account_records, key) in account_record_sets">

                <div v-if="isNumber(key)">
                    <div class="rows" v-for="account_record in account_records">
                        <div v-text="account_record.id"></div>
                        <div>{{ account_record.created_at | friendlyDateTime }}</div>
                        <div v-text="account_record.loan_id"></div>
                        <div v-text="account_record.user_id_receiver"></div>
                        <div v-text="account_record.account_user_id_doer"></div>
                        <div v-text="account_record.message"></div>
                        <div v-text="account_record.details"></div>
                        <div v-text="account_record.ip"></div>
                    </div>
                </div>

                <hr/>

                <div v-if="!isNumber(key)">
                    <div class="rows">
                        <div v-text="firstRecord(account_record_sets[key]).id"></div>
                        <div>{{ firstRecord(account_record_sets[key]).created_at | friendlyDateTime }}</div>
                        <div v-text="firstRecord(account_record_sets[key]).loan_id"></div>
                        <div v-text="firstRecord(account_record_sets[key]).user_id_receiver"></div>
                        <div v-text="firstRecord(account_record_sets[key]).account_user_id_doer"></div>
                        <div v-text="firstRecord(account_record_sets[key]).message"></div>
                        <div class="overflow-x-scroll overflow-y-scroll h-48">
                            <pre v-text="getDetails(account_record_sets[key])"></pre>
                        </div>
                        <div v-text="firstRecord(account_record_sets[key]).ip"></div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {

        props: {

            resource : {
                type     : Object,
                required : true
            }

        },

        data() {

            return {

                fetching : {
                    underway   : null,
                    completed  : null,
                    successful : null,
                    failed     : null
                },

                records : [],

                page : 1,

                pagination : null
            }
        },

        created() {

            this.fetch()
        },

        methods: {

            fetch(link)
            {
                this.getPageNumber(link);

                this.fetching.underway   = true
                this.fetching.completed  = null
                this.fetching.successful = null
                this.fetching.failed     = null

                this.superAxios(this.resource, { params : { page : this.page } }, (response)=>{

                    this.records = response.data.data;

                    this.pagination =response.data;

                    delete this.pagination.data;

                    // Just so you can see the loading indicator ;)
                    setTimeout(()=>{
                        this.fetching.underway    = false
                        this.fetching.completed   = true
                        this.fetching.successful  = true
                    }, 1000)

                }, (error)=>{

                    this.fetching.underway  = false
                    this.fetching.completed = true
                    this.fetching.failed    = true
                })
            },

            isNumber(key)
            {
                var reg = new RegExp('^[0-9]+$');

                return reg.test(key);
            },

            firstRecord(collection)
            {
                return _.first(collection);
            },

            getDetails(collection)
            {
                return _.map(collection, 'details')
            },

            isString(key)
            {
                return typeof key === 'string'
            },

            getPageNumber(link)
            {
                var output = 1;

                if(link)
                {
                    var url    = new URL(link);
                    var params = new URLSearchParams(url.search);

                    output = params.get('page');
                }

                this.page = parseInt(output)

                return output;
            },
        },

        computed : {

            paginationRange()
            {
                return _.range(this.pagination.from, this.pagination.to)
            }
        }
    }
</script>

<style scoped>

    .headings,
    .rows {
        @apply flex;
    }

    .headings div:nth-child(1),
        .rows div:nth-child(1),
    .headings div:nth-child(2),
        .rows div:nth-child(2),
    .headings div:nth-child(3),
        .rows div:nth-child(3),
    .headings div:nth-child(4),
        .rows div:nth-child(4),
    .headings div:nth-child(5),
        .rows div:nth-child(5),
    .headings div:nth-child(6),
        .rows div:nth-child(6),
    .headings div:nth-child(7),
        .rows div:nth-child(7),
    .headings div:nth-child(8),
        .rows div:nth-child(8)
    {
        @apply bg-gray-100 border border-white p-2 w-1/6
    }

</style>
