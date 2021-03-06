<?php

return <<<HTML
<form class="form x-update x-insert-char ng-cloak" action="#">
    <div class="row">
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="russian">Russian word</label>
                <input class="form-control" type="text" name="russian" ng-model="word.russian">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="russian_root">Root</label>
                <input class="form-control" type="text" name="russian_root" ng-model="word.russian_root">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="russian_form">Form</label>
                <input class="form-control" type="text" name="russian_form" ng-model="word.russian_form">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="translit_s">Transliteration (Rom)</label>
                <input class="form-control" type="text" name="translit_s" ng-model="word.translit_s">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="sanskrit_form">Form</label>
                <input class="form-control" type="text" name="sanskrit_form" ng-model="word.sanskrit_form">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-6">
            <div class="form-group">
                <label class="control-label" for="translation_r">Translation</label>
                <textarea class="form-control" name="translation_r" rows="1" ng-model="word.translation_r"></textarea>
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="translation_s">Translation (Eng)</span>
                </label>
                <textarea class="form-control" name="translation_s" rows="1" ng-model="word.translation_s"></textarea>
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="translation_s_rus">Translation (Rus)</label>
                <textarea class="form-control" name="translation_s_rus" rows="1" ng-model="word.translation_s_rus"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="alt_translit_r">Transliteration 1</label>
                <input class="form-control" type="text" name="alt_translit_r" ng-model="word.alt_translit_r">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="alt_translit_r_root">&nbsp;</label>
                <input class="form-control" type="text" name="alt_translit_r_root" ng-model="word.alt_translit_r_root">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="alt_translit_r_form">&nbsp;</label>
                <input class="form-control" type="text" name="alt_translit_r_form" ng-model="word.alt_translit_r_form">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="devanagari">Devanagari</label>
                <input class="form-control devanagari" type="text" name="devanagari" ng-model="word.devanagari">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="devanagari_form">Devanagari Form</label>
                <input class="form-control devanagari" type="text" name="devanagari_form" ng-model="word.devanagari_form">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="translit_r">Transliteration 2</label>
                <input class="form-control" type="text" name="translit_r" ng-model="word.translit_r">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="translit_r_root">&nbsp;</label>
                <input class="form-control" type="text" name="translit_r_root" ng-model="word.translit_r_root">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="translit_r_form">&nbsp;</label>
                <input class="form-control" type="text" name="translit_r_form" ng-model="word.translit_r_form">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="translit_s2r">Transliteration (Cyr)</label>
                <input class="form-control" type="text" name="translit_s2r" ng-model="word.translit_s2r">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="translit_form_s2r">Form (Cyr)</label>
                <input class="form-control" type="text" name="translit_form_s2r" ng-model="word.translit_form_s2r">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="proto_form">Praslavonic</label>
                <input class="form-control" type="text" name="proto_form" ng-model="word.proto_form">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="transcr_r_root">&nbsp;</label>
                <input class="form-control" type="text" name="transcr_r_root" ng-model="word.transcr_r_root">
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label" for="transcr_r_form">&nbsp;</label>
                <input class="form-control" type="text" name="transcr_r_form" ng-model="word.transcr_r_form">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="dhatu">Dhatu</label>
                <input class="form-control devanagari" type="text" name="dhatu" ng-model="word.dhatu">
            </div>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <label class="control-label" for="rigveda">Rig-Veda</label>
                <input class="form-control" type="checkbox" name="rigveda" ng-model="word.rigveda" ng-true-value="1">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label">Metadata</label>
                <select class="form-control" name="type_r" ng-model="word.type_r" ng-options="o.id as o.description for o in types">
                    <option value="">None</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="gender_r" ng-model="word.gender_r" ng-options="o.id as o.description for o in genders">
                    <option value="">None</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="classification_r" ng-model="word.classification_r" ng-options="o.id as o.description for o in classes">
                    <option value="">None</option>
                </select>
            </div>
        </div>
        <div class="col col-sm-8">
            <div class="form-group">
                <label class="control-label" for="source">Source (Eng)</label>
                <textarea class="form-control" name="source" rows="1" ng-model="word.source"></textarea>
            </div>
            <div class="form-group">
                <label class="control-label" for="source_r">Source (Rus)</label>
                <textarea class="form-control" name="source_r" rows="1" ng-model="word.source_r"></textarea>
            </div>
            <div class="row">
                <div class="col col-sm-4"></div>
                <div class="col col-sm-4"></div>
            </div>
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <label class="control-label">Metadata</label>
                <select class="form-control" name="type_s" ng-model="word.type_s" ng-options="o.id as o.description for o in types">
                    <option value="">None</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="gender_s" ng-model="word.gender_s" ng-options="o.id as o.description for o in genders">
                    <option value="">None</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-2">
            &nbsp;
        </div>
        <div class="col col-sm-7">
            <div class="form-group">
                <label class="control-label" for="notes_r">Notes (Rus)</label>
                <textarea class="form-control" type="text" name="notes_r" rows="1" ng-model="word.notes_r"></textarea>
            </div>
        </div>
        <div class="col col-sm-1">
            <div class="form-group">
                <label class="control-label" for="score">Rating</label>
                <input class="form-control" type="text" name="score" ng-model="word.score">
            </div>
        </div>
        <div class="col col-sm-1">
            <div class="form-group">
                <label class="control-label" for="ready_for_print">Ready (Eng)</label>
                <input class="form-control" type="checkbox" name="ready_for_print" ng-model="word.ready_for_print" ng-true-value="1">
            </div>
        </div>
        <div class="col col-sm-1">
            <div class="form-group">
                <label class="control-label" for="ready_for_print_r">Ready (Rus)</label>
                <input class="form-control" type="checkbox" name="ready_for_print_r" ng-model="word.ready_for_print_r" ng-true-value="1">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <div class="form-group">
                <label class="control-label" for="other_lang">Slavonic Cognates</label>
                <textarea class="form-control" name="other_lang" rows="1" ng-model="word.other_lang"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <div class="form-group">
                <label class="control-label" for="cognates">Cognates (Eng)</label>
                <textarea class="form-control" name="cognates" rows="1" ng-model="word.cognates"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <div class="form-group">
                <label class="control-label" for="cognates_r">Cognates (Rus)</label>
                <textarea class="form-control" name="cognates_r" rows="1" ng-model="word.cognates_r"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <div class="form-group">
                <label class="control-label" for="comments_eng">Comments (Eng)</label>
                <textarea class="form-control" name="comments_eng" rows="1" ng-model="word.comments_eng"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <div class="form-group">
                <label class="control-label" for="comments_rus">Comments (Rus)</label>
                <textarea class="form-control" name="comments_rus" rows="1" ng-model="word.comments_rus"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-12">
            <div class="form-group">
                <label class="control-label" for="comments_vasmer">Vasmer comments</label>
                <textarea class="form-control" name="comments_vasmer" rows="1" ng-model="word.comments_vasmer"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-6">
            <div class="form-group">
                <label class="control-label" for="scrap1">Scrap 1</label>
                <textarea class="form-control" name="scrap1" rows="1" ng-model="word.scrap1"></textarea>
            </div>
        </div>
        <div class="col col-sm-6">
            <div class="form-group">
                <label class="control-label" for="scrap2">Scrap 2</label>
                <textarea class="form-control" name="scrap2" rows="1" ng-model="word.scrap2"></textarea>
            </div>
        </div>
    </div>
</form>
<div id="errorModal" class="modal no-print" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Error Saving Data</h4>
            </div>
            <div class="modal-body">
                <pre class="message"></pre>
                <p>Your changes were not saved! :-(</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
HTML;
