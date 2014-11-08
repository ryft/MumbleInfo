var app = angular.module('MumbleInfo', ['ngSanitize']);

app.controller('detailsController', function($scope, $http) {
    $http.get('/api/details.php')
        .success(function(response) {
            $scope.server = response;
        }
    );
});

app.controller('treeController', function($scope, $http) {
    var ipv4Filter = function(input) {
        return input.slice(-4).join('.');
    };
    var userCols = [
        { name: "name",         title: "User name" },
        { name: "release",      title: "Client version" },
        { name: "os",           title: "Operating system" },
        { name: "osversion",    title: "OS version" },
        { name: "onlinesecs",   title: "Online time" },
        { name: "idlesecs",     title: "Idle time" },
        { name: "address",      title: "IP address",    filter: ipv4Filter },
    ];
    var channelCols = [
        { name: "name",         title: "Channel name" },
        { name: "id",           title: "Channel ID" },
        { name: "description",  title: "Description" },
    ];

    $scope.summary = 'Select a user or channel for details';
    $('#treeView')
        .on('changed.jstree', function (e, data) {

            if (data.action == 'select_node') {
                $scope.summary = '';

                var node = data.node.original;
                var id = (node.type == 'user') ? node.text : node.id;
                $http.get('/api/node.php?type=' + node.type + '&id=' + id)
                    .success(function(response) {
                        $scope.info = [];
                        var cols = (node.type == 'user') ? userCols : channelCols;
                        angular.forEach(cols, function(item) {
                            var val = response[item.name];
                            this.push({
                                title: item.title,
                                value: (item.filter) ? item.filter(val) : val,
                            });
                        }, $scope.info);
                    }
                );
            }

    })  .jstree({
        'core': {
            'data': { 'url': '/api/tree.php' }
    }});
});

