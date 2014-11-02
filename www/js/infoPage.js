$(function () {
    $('#channelViewer')
        .on('changed.jstree', function (e, data) {
            // Load data via AJAX to $('#channelInfo')
    })  .jstree({
        'core': {
            'data': { 'url': 'api/tree.php' }
    }});
});
