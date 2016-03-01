/*jshint browser:true, jquery: true*/
/*globals angular*/

angular.module('word', ['svc.sub'])
    .service('fileSvc', ['idSvc', 'langSvc', 'subSvc', function (idSvc, langSvc, subSvc) {
        'use strict';

        var id, lang;

        function _filename () {
            return id + '_' + lang + '.tex';
        }

        idSvc.subscribe(function (i) {
            id = i;
            subSvc.notify('file', _filename());
        });

        langSvc.subscribe(function (s) {
            lang = s;
            subSvc.notify('file', _filename());
        });

        return {
            subscribe: function (callback) {
                subSvc.add('file', callback);
                callback(_filename());
            },
        };
    }])

    .service('idSvc', ['subSvc', function (subSvc) {
        'use strict';

        var id = location.pathname.replace(/^.+\/(\d+)\/$/, '$1');

        return {
            subscribe: function (callback) {
                subSvc.add('id', callback);
                callback(id);
            },
        };
    }])

    .service('langSvc', ['subSvc', function (subSvc) {
        'use strict';

        var lang = sessionStorage.getItem('xetexLang') || 'eng';

        return {
            subscribe: function (callback) {
                subSvc.add('lang', callback);
                callback(lang);
            },

            update: function (s) {
                sessionStorage.setItem('xetexLang', s);
                subSvc.notify('lang', s);
            }
        };
    }])

    .directive('xid', ['idSvc', function (idSvc) {
        'use strict';

        return {
            restrict: 'A',
            link: function (scope, el) {
                idSvc.subscribe(function (id) {
                    el.val(id);
                });
            }
        };
    }])

    .directive('xlang', ['langSvc', function (langSvc) {
        'use strict';

        return {
            restrict: 'A',
            link: function (scope, el) {
                langSvc.subscribe(function (lang) {
                    el.val(lang);
                });
            }
        };
    }])

    .directive('xfile', ['fileSvc', function (fileSvc) {
        'use strict';

        return {
            restrict: 'A',
            link: function (scope, el) {
                fileSvc.subscribe(function (file) {
                    el.val(file);
                });
            }
        };
    }])

    .directive('language', ['langSvc', function (langSvc) {
        'use strict';

        return {
            restrict: 'A',
            link: function (scope, el) {
                var href = el[0].href;

                langSvc.subscribe(function (lang) {
                    if (href.indexOf(lang) > -1) {
                        $(el).tab('show');
                    }
                });

                el.click(function (e) {
                    var lang = (href.indexOf('eng') > -1) ? 'eng' : 'rus';

                    e.preventDefault();

                    langSvc.update(lang);
                });
            }
        };
    }])
;

angular.element(document).ready(function () {
    'use strict';
    angular.bootstrap(document.body, ['word']);
});
