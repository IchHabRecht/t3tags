<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:t3tags/Resources/Private/Language/locallang_tca.xlf:tx_t3tags_tag',
        'descriptionColumn' => 'description',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'default_sortby' => 'ORDER BY title',
        'versioningWS' => false,
        'rootLevel' => -1,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignoreRootLevelRestriction' => true,
        ],
        'searchFields' => 'title',
        'typeicon_classes' => [
            'default' => 'mimetypes-x-sys_category',
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'title',
    ],
    'palettes' => [],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,--palette--;;timeRestriction,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                    description,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:t3tags/Resources/Private/Language/locallang_tca.xlf:tx_t3tags_tag.title',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim,required,lower',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:t3tags/Resources/Private/Language/locallang_tca.xlf:tx_t3tags_tag.description',
            'config' => [
                'type' => 'text',
                'default' => '',
            ],
        ],
        'items' => [
            'label' => 'LLL:EXT:t3tags/Resources/Private/Language/locallang_tca.xlf:tx_t3tags_tag.items',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => '*',
                'MM' => 'sys_category_record_mm',
                'MM_oppositeUsage' => [],
                'size' => 10,
                'fieldWizard' => [
                    'recordsOverview' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],
    ],
];
