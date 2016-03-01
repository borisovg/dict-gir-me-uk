<?php

return <<<HTML
<div class="keyboard-spacer ng-cloak" ng-show="showKeyboard">&nbsp;</div>
<div class="keyboard ng-cloak" ng-show="showKeyboard">
    <div class="container-fluid">
        <table>
            <tr>
                <td ng-repeat="(label, groups) in symbols">{{label}}</td>
                <td class="align-right">
                    <button type="button" class="btn btn-xs btn-default toggle-keyboard">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td ng-repeat="(label, groups) in symbols">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" ng-repeat="(letter, chars) in groups" ng-click="show_group(letter)">{{letter}}</button>
                    </div>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" class="align-middle">
                    <div ng-repeat="(label, groups) in symbols">
                        <div ng-repeat="(letter, chars) in groups">
                            <div class="btn-group group" role="group" ng-show="showSymbolGroup === letter">
                                <button type="button" class="btn btn-default" ng-repeat="c in chars track by \$index" ng-click="insert_char(c)">{{c}}</button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
HTML;
