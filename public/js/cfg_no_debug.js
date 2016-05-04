/*jshint browser:true*/
/*globals angular*/

angular.module('cfg.noDebug', [])
    .config(['$compileProvider', function ($compileProvider) {
        'use strict';

        $compileProvider.debugInfoEnabled(false);
    }])
;
