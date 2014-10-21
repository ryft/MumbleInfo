$(function () { $('#channelViewer').jstree({
    'core': {
        'data': { 'url': 'api/channels.php' }
    }})
});
$('#channelViewer').on("changed.jstree", function (e, data) {
      console.log(data.selected);
});
