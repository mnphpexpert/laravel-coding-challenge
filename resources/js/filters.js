Vue.filter('friendlyDateTime', function (datetime) {
    return moment(datetime).format('MMMM Do YYYY, h:mm:ss a');
})
