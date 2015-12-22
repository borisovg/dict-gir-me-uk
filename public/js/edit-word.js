/*jshint browser:true, jquery:true*/
/*globals angular*/

angular.module('edit-word', [])
    .run (['$rootScope', '$http', function ($rootScope, $http) {
        'use strict';

        // make sure auth does not time out on the edit form
        (function loop () {
            setTimeout(function () {
                $http.get('/api/ping').then(false, function (err) {
                    $rootScope.$broadcast('error', err.data);
                });

                loop();
            }, 300000);
        }());
    }])

    .service('classSvc', ['$rootScope', '$http', 'subSvc', function ($rootScope, $http, subSvc) {
        'use strict';

        var classes = {};

        $http.get('/api/classes').then(
            function (res) {
                classes = res.data;
                subSvc.notify('classes', classes);
            },
            function (err) {
                $rootScope.$broadcast('error', err.data);
            }
        );
        
        return {
            subscribe: function (callback) {
                subSvc.add('classes', callback);
                callback(classes);
            }
        };
    }])

    .service('genderSvc', ['$rootScope', '$http', 'subSvc', function ($rootScope, $http, subSvc) {
        'use strict';

        var genders = {};

        $http.get('/api/genders').then(
            function (res) {
                genders = res.data;
                subSvc.notify('genders', genders);
            },
            function (err) {
                $rootScope.$broadcast('error', err.data);
            }
        );
        
        return {
            subscribe: function (callback) {
                subSvc.add('genders', callback);
                callback(genders);
            }
        };
    }])

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
    
    .service('typeSvc', ['$rootScope', '$http', 'subSvc', function ($rootScope, $http, subSvc) {
        'use strict';

        var types = {};

        $http.get('/api/types').then(
            function (res) {
                types = res.data;
                subSvc.notify('types', types);
            },
            function (err) {
                $rootScope.$broadcast('error', err.data);
            }
        );
        
        return {
            subscribe: function (callback) {
                subSvc.add('types', callback);
                callback(types);
            }
        };
    }])

    .service('wordSvc', ['$rootScope', '$http', 'subSvc', function ($rootScope, $http, subSvc) {
        'use strict';

        var word = {},
            id = [location.pathname.replace(/^.+\/(\d+)\/edit\/$/, '$1')],
            uri = '/api/words/' + id;

        $http.get(uri).then(
            function (res) {
                word = res.data;
                subSvc.notify('word', word);
            },
            function (err) {
                $rootScope.$broadcast('error', err.data);
            }
        );
        
        return {
            subscribe: function (callback) {
                subSvc.add('word', callback);
                callback(word);
            },

            update: function (k, v, callback) {
                $http.post(uri, {key: k, val: v}).then(
                    function (res) {
                        callback(false, res.data);    
                    },
                    function (err) {
                        $rootScope.$broadcast('error', err.data);
                        callback(err.data);
                    }
                );
            }
        };
    }])
    
    .directive('formGroup', function () {
        'use strict';

        return {
            restrict: 'C',
            link: function (scope, el) {
                $('input, select, textarea', el).each(function () {
                    var m = $(this).attr('ng-model').replace(/^word\./, ''),
                        l = document.createElement('label');

                    l.className = 'control-label print';
                    l.textContent = m;

                    $(el).append(l);
                });
            }
        };
    })

    .directive('textarea', function () {
        'use strict';

        function _resize (el) {
            el[0].style.height = 'auto';
            el[0].style.height = el[0].scrollHeight + 4 + 'px';
        }

        return {
            restrict: 'E',
            link: function (scope, el) {
                el.on('keydown', function () {
                    _resize(el);
                });

                scope.$watch('word', function () {
                    _resize(el);
                });
            }
        };
    })

    .directive('update', ['wordSvc', function (wordSvc) {
        'use strict';

        return {
            restrict: 'A',
            link: function (scope, el) {
                var cache = {};

                function _cache (ev) {
                    var name = ev.target.name,
                        value = scope.word[name];

                    cache[name] = value;
                }

                function _update (ev) {
                    var name = ev.target.name,
                        value = scope.word[name];

                    if (cache[name] !== value) {
                        wordSvc.update(name, value, function (err) {
                            var m, v,
                                p = angular.element(ev.target).parent();

                            if (err) {
                                m = $('#errorModal');
                                v = cache[name];
                                
                                p.addClass('has-error');
                                
                                if (typeof err === 'object') {
                                    $('.message', m).text(JSON.stringify(err, null, 2));

                                } else {
                                    $('.message', m).text(err);
                                }

                                m.modal({show: true});

                                m.on('hidden.bs.modal', function () {
                                    m.off('hidden.bs.modal');
                                    ev.target.select();
                                    cache[name] = v;
                                });
                            
                            } else {
                               p.removeClass('has-error');
                            }
                        });
                    }
                }

                angular.forEach(angular.element(el).find('input'), function (el) {
                    var type = el.type;

                    if (type === 'text') {
                        el.onfocus = _cache; 
                        el.onblur = _update; 

                    } else if (type === 'checkbox') {
                        el.onchange = _update;
                    }
                });
                
                angular.forEach(angular.element(el).find('select'), function (el) {
                    el.onfocus = _cache; 
                    el.onchange = function (ev) {
                        _update(ev); 
                        _cache(ev); 
                    };
                });
                
                angular.forEach(angular.element(el).find('textarea'), function (el) {
                    el.onfocus = _cache; 
                    el.onblur = _update; 
                });
            }
        };
    }])

    .controller('editWordCtrl', ['$scope', 'classSvc', 'genderSvc', 'typeSvc', 'wordSvc', function ($scope, classSvc, genderSvc, typeSvc, wordSvc) {
        'use strict';

        classSvc.subscribe(function (list) {
            $scope.$applyAsync(function () {
                $scope.classes = list;
            });
        });

        genderSvc.subscribe(function (list) {
            $scope.$applyAsync(function () {
                $scope.genders = list;
            });
        });
        
        typeSvc.subscribe(function (list) {
            $scope.$applyAsync(function () {
                $scope.types = list;
            });
        });

        wordSvc.subscribe(function (word) {
            $scope.$applyAsync(function () {
                $scope.word = word;
                $scope.$broadcast('update');
            });
        });
    }])
;

angular.element(document).ready(function () {
    'use strict';
    angular.bootstrap(document.body, ['edit-word']);
});
