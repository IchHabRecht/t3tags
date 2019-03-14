<?php
declare(strict_types=1);
namespace IchHabRecht\T3tags\Configuration;

use IchHabRecht\T3tags\Error\Exception\EmptyTableNameException;
use IchHabRecht\T3tags\Error\Exception\UnknownTableException;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TagRegistry
{
    public function makeTaggable(
        string $tableName,
        string $fieldName = 'tx_t3tags_tags',
        array $options = [],
        bool $override = false
    ): bool {
        $didRegister = false;

        if (empty($tableName)) {
            throw new EmptyTableNameException(
                'Empty table name for fieldName "' . $fieldName . '" given.',
                1522934699
            );
        }
        if (!isset($GLOBALS['TCA'][$tableName])) {
            throw new UnknownTableException(
                'Unknown tableName "' . $tableName . '" given.',
                1552560420
            );
        }

        if ($override) {
            $this->remove($tableName, $fieldName);
        }

        if (empty($GLOBALS['TCA'][$tableName]['columns'][$fieldName])) {
            $this->applyTcaForTableAndField($tableName, $fieldName, $options);
            $didRegister = true;
        }

        return $didRegister;
    }

    protected function remove(string $tableName, string $fieldName)
    {
        if (isset($GLOBALS['TCA'][$tableName]['columns'][$fieldName])) {
            unset($GLOBALS['TCA'][$tableName]['columns'][$fieldName]);
        }
    }

    protected function applyTcaForTableAndField(string $tableName, string $fieldName, array $options)
    {
        $this->addTcaColumn($tableName, $fieldName, $options);
        $this->addToAllTCAtypes($tableName, $fieldName, $options);
    }

    protected function addTcaColumn(string $tableName, string $fieldName, array $options)
    {
        if (!isset($GLOBALS['TCA'][$tableName]['columns'])) {
            return;
        }

        $label = $options['label'] ?? 'LLL:EXT:t3tags/Resources/Private/Language/locallang_tca.xlf:tx_t3tags_tag.tx_t3tags_tags';
        $exclude = !isset($options['exclude']) || (bool)$options['exclude'];
        $fieldConfiguration = $options['fieldConfiguration'] ?? [];
        $columns = [
            $fieldName => [
                'exclude' => $exclude,
                'label' => $label,
                'config' => $this->getTcaFieldConfiguration($tableName, $fieldName, $fieldConfiguration),
            ],
        ];

        if (isset($options['l10n_mode'])) {
            $columns[$fieldName]['l10n_mode'] = $options['l10n_mode'];
        }
        if (isset($options['l10n_display'])) {
            $columns[$fieldName]['l10n_display'] = $options['l10n_display'];
        }
        if (isset($options['displayCond'])) {
            $columns[$fieldName]['displayCond'] = $options['displayCond'];
        }

        if (
            !isset($options['interface']) || $options['interface']
            && !empty($GLOBALS['TCA'][$tableName]['interface']['showRecordFieldList'])
            && !GeneralUtility::inList($GLOBALS['TCA'][$tableName]['interface']['showRecordFieldList'], $fieldName)
        ) {
            $GLOBALS['TCA'][$tableName]['interface']['showRecordFieldList'] .= ',' . $fieldName;
        }

        ExtensionManagementUtility::addTCAcolumns($tableName, $columns);
    }

    protected function addToAllTCAtypes(string $tableName, string $fieldName, array $options)
    {
        if (!isset($GLOBALS['TCA'][$tableName]['columns'])) {
            return;
        }

        $fieldList = $options['fieldList'] ?? $fieldName;
        $typesList = $options['typesList'] ?? '';
        $position = $options['position'] ?? '';

        ExtensionManagementUtility::addToAllTCAtypes($tableName, $fieldList, $typesList, $position);
    }

    protected function getTcaFieldConfiguration(string $tableName, string $fieldName, array $fieldConfigurationOverride): array
    {
        $fieldConfiguration = [
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_t3tags_tag',
            'foreign_table' => 'tx_t3tags_tag',
            'MM' => 'tx_t3tags_tag_mm',
            'MM_opposite_field' => 'items',
            'MM_match_fields' => [
                'tablenames' => $tableName,
                'fieldname' => $fieldName,
            ],
            'fieldControl' => [
                'elementBrowser' => [
                    'disabled' => true,
                ],
            ],
            'fieldInformation' => [
                'tagInformation' => [
                    'renderType' => 'StaticText',
                    'options' => [
                        'labels' => [
                            [
                                'label' => 'LLL:EXT:t3tags/Resources/Private/Language/locallang_tca.xlf:tx_t3tags_tag.notice',
                                'bold' => true,
                                'italic' => true,
                            ],
                        ],
                    ],
                ],
            ],
            'fieldWizard' => [
                'recordsOverview' => [
                    'disabled' => true,
                ],
                'tableList' => [
                    'disabled' => true,
                ],
            ],
            'suggestOptions' => [
                'default' => [
                    'minimumCharacters' => 2,
                    'searchWholePhrase' => true,
                    'receiverClass' => \IchHabRecht\T3tags\Form\Wizard\SuggestWizardReceiver::class,
                ],
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ];

        if (!empty($fieldConfigurationOverride)) {
            ArrayUtility::mergeRecursiveWithOverrule(
                $fieldConfiguration,
                $fieldConfigurationOverride
            );
        }

        return $fieldConfiguration;
    }
}
