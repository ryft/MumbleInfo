$(function () {
    $('#channelViewer')
        .on('changed.jstree', function (e, data) {

            if (data.action == 'select_node') {
                var node = data.node.original;
                if (node.type == 'channel') {
                    $('#channelInfo').load('api/channelInfo.php?id=' + node.id);
                } else if (node.type == 'user') {
                    $('#channelInfo').load('api/userInfo.php?name=' + node.text);
                }
            }

    })  .jstree({
        'core': {
            'data': { 'url': 'api/tree.php' }
    }});
});
