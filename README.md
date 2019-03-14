# TYPO3 Extension t3tags

[![Latest Stable Version](https://img.shields.io/packagist/v/ichhabrecht/t3tags.svg)](https://packagist.org/packages/ichhabrecht/t3tags)
[![Build Status](https://img.shields.io/travis/IchHabRecht/t3tags/master.svg)](https://travis-ci.org/IchHabRecht/t3tags)
[![StyleCI](https://styleci.io/repos/174751542/shield?branch=master)](https://styleci.io/repos/174751542)

Generate tag fields for every record type.

## Features

- Integrates into Core API and extends `group` field behaviour
- New tags can be added on the fly and are created only when the record is saved
- New tags that are added to multiple (tag) fields are created only once in database

## Installation

1. Simply install the extension with Composer or the [Extension Manager](https://extensions.typo3.org/extension/t3tags/).

`composer require ichhabrecht/t3tags`

2. In the extension settings configure a page uid, where tags should be stored.

## Usage

**Register a new field using the TagRegistry**

- Add or extend a file in Configuration/TCA/Overrides

```
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
```

*Parameters*

1. Table name: Existing TCA table that should be extended
2. Field name: Name of the new tag field that should be added
3. Options: Additional field configuration, according to TCA field configuration
    - label
    - exclude
    - fieldConfiguration (config)
    - l10n_display
    - l10n_mode
    - displayCond
    - position
    - interface
    - fieldList
    - typesList
4. override: True, if any existing field configuration should be replaced with the one provided

**Get all tags for a record by field**

```
$tagRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\IchHabRecht\T3tags\Domain\Repository\TagRepository::class);
$tagRepository->findTagsByField('tt_content', 'relevant_tags', 42);
```

- Returns all tags (as array) from a `tt_content` element with uid `42` and its field `relevant_tags`

**Get all tags by record**

```
$tagRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\IchHabRecht\T3tags\Domain\Repository\TagRepository::class);
$tagRepository->findTagsByRecord('tt_content', 42);
```

- Returns all tags (as array) from a `tt_content` element with uid `42`. According to the example registration from above, tags from `relevant_tags` and `content_tags` are returned.
