angular.module('infoFilters', [])

.filter('identity', function() {
    return function(input) {
        return input;
    }
})

.filter('ipv4', function() {
    return function(input) {
        return input.slice(-4).join('.');
    }
})

.filter('date', function() {
    return function(input) {
        return moment(input * 1000).format('D MMM YYYY HH:mm:ss');
    }
})

.filter('interval', function() {
    return function(input) {
        return moment.duration(input * 1000).humanize();
    }
})

.filter('ago', function() {
    return function(input) {
        return moment.duration(-input * 1000).humanize(true);
    }
});

