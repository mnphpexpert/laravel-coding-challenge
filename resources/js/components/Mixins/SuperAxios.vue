<script>
    export default {

        methods: {

            superAxios(resource, data, success, error)
            {
                return window.axios[resource.method](resource.url, data).then(success, error)
            }

        }
    }
</script>
