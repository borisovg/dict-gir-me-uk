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
            el.style.height = 'auto';
            el.style.height = el.scrollHeight + 4 + 'px';
        }

        return {
            restrict: 'E',
            link: function (scope, el) {
                el.on('keydown', function () {
                    scope.$applyAsync(function () {
                        _resize(el[0]);
                    });
                });

                scope.$watch('word', function () {
                    scope.$applyAsync(function () {
                        _resize(el[0]);
                    });
                });
            }
        };
    })

    .directive('toggleKeyboard', ['$rootScope', function ($rootScope) {
        'use strict';

        return {
            restrict: 'C',
            link: function (scope, el) {
                $(el).click(function () {
                    $(el).blur();
                    $rootScope.$broadcast('toggle-keyboard');
                });
            }
        };
    }])

    .directive('insertChar', function () {
        'use strict';

        return {
            restrict: 'C',
            link: function (scope, el) {
                $(':text, textarea', el).each(function () {
                    $(this).blur(function() { 
                        scope.lastInput = this;
                        scope.lastInputCursorPosition = this.selectionStart;
                    });
                });
            }
        };
    })

    .directive('update', ['wordSvc', function (wordSvc) {
        'use strict';

        return {
            restrict: 'C',
            link: function (scope) {
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
                                p = $(ev.target).parent();

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
                                    $(ev.target).select();
                                    cache[name] = v;
                                });
                            
                            } else {
                               p.removeClass('has-error');
                            }
                        });
                    }
                }

                $(':text, textarea').each(function() {
                    $(this).focus(_cache);
                    $(this).blur(_update);
                });

                $(':checkbox').each(function() {
                    $(this).change(_update);
                });
                
                $('select').each(function() {
                    $(this).focus(_cache);
                    $(this).change(function (ev) {
                        _update(ev);
                        _cache(ev);
                    });
                });
            }
        };
    }])

    .controller('editWordCtrl', ['$scope', 'classSvc', 'genderSvc', 'typeSvc', 'wordSvc', function ($scope, classSvc, genderSvc, typeSvc, wordSvc) {
        'use strict';

        $scope.showKeyboard = false;
        $scope.lastInput = false;

        $scope.symbols = {
            Russian: {
                а: ['а́', 'а̀', 'а̋', 'а̏'],
                е: ['е́', 'ѐ', 'е̋', 'е̏'],
                и: ['и́', 'ѝ', 'и̋', 'и̏'],
                о: ['о́', 'о̀', 'о̋', 'о̏'],
                у: ['у́', 'у̀', 'ӳ', 'у̏'],
                э: ['э́', 'э̀'],
                ы: ['ы́']
            },
            Latin: {
                a: ['á', 'à', 'ă', 'ắ', 'ā', 'ā́', 'ä', 'ą', 'ą́', 'a̋', 'ȁ', 'a͂'],
                e: ['é', 'è', 'ĕ', 'ė', 'Ė', 'ė͂', 'ė́', 'ė̀', 'ē', 'ḗ', 'ë', 'ę', 'ę́', 'e̋', 'ȅ', 'e͂', 'ǝ'],
                i: ['í', 'ì', 'ĭ', 'ī', 'ï', 'į', 'i̋', 'ȉ', 'i͂'],
                o: ['ó', 'ò', 'ŏ', 'ō', 'ṓ', 'ö', 'ǫ', 'ǫ́', 'ő', 'ȍ', 'o͂'],
                u: ['ú', 'ù', 'ŭ', 'ū', 'ū́', 'ü', 'ų', 'ų́', 'ű', 'ȕ', 'u͂'],
                y: ['ý', 'ỳ', 'y̋', 'y̏'],
                æ: ['æ', 'Æ'],
                c: ['c̀', 'ć', 'č', 'Č'],
                d: ['ḍ', 'ð'],
                h: ['ḥ', 'h̯'],
                j: ['ǰ', 'ɣ'],
                l: ['ḷ', 'ḹ', 'l̥', 'l̥'],
                m: ['m', 'ṁ', 'm̥'],
                n: ['ñ', 'ṇ', 'n̥'],
                r: ['ř', 'ŕ', 'ṛ', 'ṝ', 'r̥', 'r̃'],
                s: ['š', 'ś', 'ṣ', 'Š', 'Ś'],
                t: ['ṭ'],
                x: ['x̣', 'ẋ'],
                z: ['ž', 'Ž'],
                '#': ['ʷ', 'ʰ', 'ʲ', '‘', '’', '“', '”', '#', '/', '<', '>', '|', '«', '»']
            }
        };

        $scope.show_group = function (letter) {
            $scope.showSymbolGroup = letter;
        };

        $scope.insert_char = function (c) {
            var before, after, text;

            if (!$scope.lastInput) {
                return;
            }

            $scope.$applyAsync(function () {
                text = $scope.lastInput.value;
                before = text.substring(0, $scope.lastInputCursorPosition);
                after = text.substring($scope.lastInputCursorPosition, text.length);

                $scope.word[$scope.lastInput.name] = before + c + after;

                $scope.lastInput.selectionStart = $scope.lastInputCursorPosition + c.length;
                $scope.lastInput.selectionEnd = $scope.lastInputCursorPosition + c.length;
            });
            
            $($scope.lastInput).focus();
       };

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

        $scope.$on('toggle-keyboard', function () {
            $scope.$applyAsync(function () {
                $scope.showKeyboard = ($scope.showKeyboard) ? false : true;
            });
        });
    }])
;

$(document).ready(function () {
    'use strict';
    angular.bootstrap(document.body, ['edit-word']);
});
