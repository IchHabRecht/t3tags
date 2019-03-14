<?php
defined('TYPO3_MODE') || die();

(function () {
    $tagRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\IchHabRecht\T3tags\Configuration\TagRegistry::class);

    $tagRegistry->makeTaggable(
        'tt_content',
        'relevant_tags',
        [
            'label' => 'Relevant tags',
            'position' => 'after:--palette--;;access',
            'fieldConfiguration' => [
                'maxitems' => 5,
                'fieldInformation' => [
                    'tagInformation' => [
                        'options' => [
                            'labels' => [
                                0 => [
                                    'label' => 'Add here up to five super relevant tags',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    );

    $tagRegistry->makeTaggable(
        'tt_content',
        'content_tags',
        [
            'label' => 'Content tags',
            'position' => 'after:relevant_tags',
            'fieldConfiguration' => [
                'fieldInformation' => [
                    'tagInformation' => [
                        'options' => [
                            'labels' => [
                                0 => [
                                    'label' => 'Add here unlimited content tags that describe your topic and the content detail',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    );
})();
