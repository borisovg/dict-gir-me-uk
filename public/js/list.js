/*jshint browser:true*/
/*globals angular*/

angular.module('listOfWords', ['svc.sub'])
    .service('filterSvc', ['subSvc', function (subSvc) {
        'use strict';

        var filters = (sessionStorage.getItem('filters')) ? JSON.parse(sessionStorage.getItem('filters')) : {};

        function _get () {
            var k, o = {};
            
            for (k in filters) {
                if (filters.hasOwnProperty(k)) {
                    o[k] = filters[k];
                }
            }

            return o;
        }

        return {
            get: function () {
                return _get();
            },

            subscribe: function (callback) {
                subSvc.add('filters', callback);
                callback(_get());
            },

            update: function (o) {
                var k, v;

                for (k in o) {
                    if (o.hasOwnProperty(k)) {
                        v = o[k];

                        if (typeof v === 'object' || filters[k] !== v) {
                            filters[k] = v;
                            subSvc.notify('filters', filters);
                            sessionStorage.setItem('filters', JSON.stringify(filters));
                        }
                    }
                }

            }
        };
    }])

    .service('letterSvc', ['$rootScope', '$http', 'subSvc', function ($rootScope, $http, subSvc) {
        'use strict';

        var letters = (sessionStorage.getItem('letters')) ? JSON.parse(sessionStorage.getItem('letters')) : [];

        $http.get('/api/letters').then(
            function (res) {
                var collator = new Intl.Collator('ru');
    
                letters = res.data;

                letters = letters.map(function (v) {
                    return (v) ? v.toUpperCase() : 'NULL';
                });

                letters = letters.filter(function (v, i, a) {
                    return (a.indexOf(v) === i);
                });

                letters.sort(collator.compare);

                subSvc.notify('letters', letters);
                sessionStorage.setItem('letters', JSON.stringify(letters));
            },
            function (err) {
                $rootScope.$broadcast('error', err.data);
            }
        );

        return {
            subscribe: function (callback) {
                subSvc.add('letters', callback);
                callback(letters);
            }
        };
    }])

    .service('listSvc', ['$rootScope', '$http', 'subSvc', function ($rootScope, $http, subSvc) {
        'use strict';

        var words = (sessionStorage.getItem('words')) ? JSON.parse(sessionStorage.getItem('words')) : [];

        return {
            subscribe: function (callback) {
                subSvc.add('words', callback);
                callback(words);
            },

            update: function (filters) {
                $http.post('/api/words', filters).then(
                    function (res) {
                        words = res.data;
                        subSvc.notify('words', words);
                        sessionStorage.setItem('words', JSON.stringify(words));
                    },
                    function (err) {
                        $rootScope.$broadcast('error', err.data);
                    }
                );
            }
        };
    }])

    .service('langSvc', function () {
        'use strict';

        var lang = sessionStorage.getItem('xetexLang') || 'eng';

        return {
            get: function () {
                return lang;
            },

            set: function (l) {
                lang = l;
                sessionStorage.setItem('xetexLang', l);
            },
        };
    })

    .directive('xfile', ['filterSvc', function (filterSvc) {
        'use strict';

        return {
            restrict: 'A',
            link: function (scope, el) {
                filterSvc.subscribe(function (f) {
                    el.val('list_' + f.lang + '.tex');
                });
            }
        };
    }])

    .controller('errorCtrl', ['$scope', function ($scope) {
        'use strict';

        $scope.error = '';

        $scope.$on('error', function (ev, err) {
            $scope.$applyAsync(function () {
                if (typeof err === 'object') {
                    if (err.code === 401) {
                        return document.location.reload();
                    }

                    $scope.error = JSON.stringify(err, null, 2);

                } else {
                    $scope.error = err;
                }
            });
        });
    }])

    .controller('filterCtrl', ['$scope', 'filterSvc', 'letterSvc', 'listSvc', 'langSvc', function ($scope, filterSvc, letterSvc, listSvc, langSvc) {
        'use strict';

        $scope.filters = {};
        $scope.lang = langSvc.get();
        $scope.letters = [];
        $scope.scores = [0, 1, 2, 3, 4, 5];

        filterSvc.subscribe(function (filters) {
            $scope.$applyAsync(function () {
                $scope.filters = filters;
            });
        });

        letterSvc.subscribe(function (letters) {
            $scope.$applyAsync(function () {
                $scope.letters = letters;
            });
        });
        
        listSvc.subscribe(function (list) {
            $scope.$applyAsync(function () {
                $scope.xids = list.map(function (o) {
                    return o.id;
                }).join(',');
            });
        });

        $scope.toggleScore = function (s) {
            var i;

            $scope.filters.scores = $scope.filters.scores || [];
            i = $scope.filters.scores.indexOf(s);

            if (i > -1) {
                $scope.filters.scores.splice(i);
            
            } else {
                $scope.filters.scores.push(s);
            }
        };

        $scope.$watch('filters', function (filters) {
            filterSvc.update(filters);
            listSvc.update(filters);
        }, true);
        
        $scope.$watch('lang', function (lang) {
            langSvc.set(lang);
        }, true);
    }])
    
    .controller('wordsCtrl', ['$scope', 'listSvc', function ($scope, listSvc) {
        'use strict';

        var collator = new Intl.Collator('ru');
        
        $scope.letters = {};
        $scope.words = {};
        $scope.wordCount = 0;

        function _sort_words (o) {
            var k;

            for (k in o) {
                if (o.hasOwnProperty(k)) {
                    o[k].sort(collator.compare);
                }
            }
        }

        function _to_columns (o) {
            var a, c, i, j, k, max, cols = 3;
            
            for (k in o) {
                if (o.hasOwnProperty(k)) {
                    a = [[]];
                    c = 0;
                    j = 0;
                    max = Math.ceil(o[k].length / cols);

                    for (i = 0; i < o[k].length; i +=1) {
                        a[c].push(o[k][i]);
                        j += 1;

                        if (j >= max) {
                            c += 1;
                            a[c] = [];
                            j = 0;
                        }
                    }

                    o[k] = a;
                }
            }
        }
        
        listSvc.subscribe(function (list) {
            var i, l, o;

            o = {};

            for (i = 0; i < list.length; i += 1) {
                l = (list[i].russian) ? list[i].russian.substr(0, 1).toUpperCase() : 'NULL';
                o[l] = o[l] || [];
                o[l].push(list[i]);
            }

            _sort_words(o);
            _to_columns(o);
            
            $scope.$applyAsync(function () {
                $scope.letters = Object.keys(o).sort(collator.compare);
                $scope.words = o;
            });
        });
        
        listSvc.subscribe(function (list) {
            $scope.$applyAsync(function () {
                $scope.wordCount = list.length;
            });
        });
    }])
;

angular.element(document).ready(function () {
    'use strict';
    angular.bootstrap(document.body, ['listOfWords']);
});
