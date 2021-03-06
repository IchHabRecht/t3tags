/**
 * Module: TYPO3/CMS/T3tags/T3tagsGroupSuggestWizard
 */
define(['jquery', 'TYPO3/CMS/Backend/FormEngine'], function($, FormEngine) {
    'use strict';

    var T3tagsGroupSuggestWizard = {};

    T3tagsGroupSuggestWizard.initialize = function() {
        $('.t3tags-taggable').closest('.formengine-field-item').find('.t3-form-suggest').filter(function() {
            return !$(this).data('t3tags-taggable-initialized');
        }).each(function() {
            $(this).data('t3tags-taggable-initialized', true);
            var autocomplete = $(this).autocomplete();
            var onSelectCallback = autocomplete.options.onSelect;
            var transformResultCallback = autocomplete.options.transformResult;
            autocomplete.setOptions({
                transformResult: function(response) {
                    response = transformResultCallback(response);

                    var $form = FormEngine.getFormElement();
                    var tagData = $form.data('tx_t3tags_tag') || {};

                    response.suggestions = $.map(response.suggestions, function(dataItem) {
                        if (typeof dataItem.data.uid == 'string' && dataItem.data.uid.indexOf('NEW') === 0) {
                            var key = dataItem.data.label.toLowerCase();
                            if (key in tagData) {
                                dataItem.data.uid = tagData[key];
                            } else {
                                tagData[key] = dataItem.data.uid;
                            }
                        }
                        return dataItem;
                    });

                    $form.data('tx_t3tags_tag', tagData);

                    return response;
                },
                onSelect: function(suggestion) {
                    if ($.isFunction(onSelectCallback)) {
                        onSelectCallback.call(this, suggestion);
                    }
                    var $this = $(this);
                    if (suggestion.data.table === 'tx_t3tags_tag'
                        && typeof suggestion.data.uid == 'string'
                        && suggestion.data.uid.indexOf('NEW') === 0
                    ) {
                        var $parent = $this.parent();
                        var pid = (typeof suggestion.data.pid !== 'undefined') ? suggestion.data.pid : $this.data('pid');
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'data[tx_t3tags_tag][' + suggestion.data.uid + '][pid]',
                            value: pid
                        }).appendTo($parent);
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'data[tx_t3tags_tag][' + suggestion.data.uid + '][title]',
                            value: suggestion.data.label
                        }).appendTo($parent);
                    }
                    $this.focus();
                    $this.val('');
                    $this.autocomplete().hide();
                }
            })
        });
    };

    T3tagsGroupSuggestWizard.reinitialize = FormEngine.reinitialize;

    FormEngine.reinitialize = function() {
        T3tagsGroupSuggestWizard.reinitialize();

        if ($('.t3-form-suggest').length) {
            require(['TYPO3/CMS/Backend/FormEngineSuggest'], function() {
                $(function() {
                    T3tagsGroupSuggestWizard.initialize();
                })
            });
        }
    };

    return T3tagsGroupSuggestWizard;
});
