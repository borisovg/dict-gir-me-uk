/*jshint browser:true*/
/*globals angular*/

angular.module('svc.sub', [])
    .service('subSvc', function () {
        'use strict';

        var subs = {};

        return {
            add: function (uri, callback) {
                subs[uri] = subs[uri] || [];
                subs[uri].push(callback);
            },

            notify: function (uri, data) {
                var i;

                if (!subs[uri]) {
                    return;
                }

                for (i = 0; i < subs[uri].length; i += 1) {
                    subs[uri][i](data);
                }
            }
        };
    })
;
