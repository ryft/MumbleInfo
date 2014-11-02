$(function () {
    $('#channelViewer')
        .on('changed.jstree', function (e, data) {

            if (data.action == 'select_node') {
                var node = data.node.original;
                var id = (node.type == 'channel') ? node.id : node.text;
                $('#channelInfo').load('api/details.php?type=' + node.type + '&id=' + id);
            }

    })  .jstree({
        'core': {
            'data': { 'url': 'api/tree.php' }
    }});
});
