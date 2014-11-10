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
    var userKeys = [
        { name: "name",         title: "User name" },
        { name: "release",      title: "Client version" },
        { name: "os",           title: "Operating system" },
        { name: "osversion",    title: "OS version" },
        { name: "onlinesecs",   title: "Online time" },
        { name: "idlesecs",     title: "Idle time" },
        { name: "address",      title: "IP address",    filter: ipv4Filter },
    ];
    var channelKeys = [
        { name: "name",         title: "Channel name" },
        { name: "id",           title: "Channel ID" },
        { name: "description",  title: "Description" },
    ];

    $scope.summary = 'Select a user or channel for details';
    $('#treeView')
        .on('changed.jstree', function (e, data) {

            if (data.action == 'select_node') {
                var node = data.node.original;
                $http.get('/api/node.php?type=' + node.type + '&id=' + node.id)
                    .success(function(response) {
                        $scope.summary  = '';
                        $scope.info     = [];

                        // Select data keys depending on node type
                        var keys = (node.type == 'user') ? userKeys : channelKeys;
                        angular.forEach(keys, function(item) {

                            // If a filter is defined, apply it now
                            var val = response[item.name];
                            if (typeof item.filter !== 'undefined' && typeof val !== 'undefined') {
                                val = item.filter(val);
                            }

                            this.push({
                                title: item.title,
                                value: val,
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

