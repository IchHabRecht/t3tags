<?php
declare(strict_types=1);
namespace IchHabRecht\T3tags\Domain\Repository;

use TYPO3\CMS\Core\Database\RelationHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TagRepository
{
    public function findTagsByField(string $table, string $field, int $uid): array
    {
        if (!$this->isTaggableField($table, $field)) {
            return [];
        }

        $fieldConfig = $GLOBALS['TCA'][$table]['columns'][$field];
        $relationHandler = GeneralUtility::makeInstance(RelationHandler::class);
        $relationHandler->start(
            0,
            $fieldConfig['config']['allowed'],
            $fieldConfig['config']['MM'],
            $uid,
            $table,
            $fieldConfig['config']
        );
        $relationHandler->getFromDB();
        $relationHandler->purgeItemArray();

        return $relationHandler->results[$fieldConfig['config']['allowed']] ?? [];
    }

    public function findTagsByRecord(string $table, int $uid): array
    {
        $tagFields = $this->getTagFields($table);
        if (empty($tagFields)) {
            return [];
        }

        $tags = [];
        foreach ($tagFields as $field) {
            $tags[$field] = $this->findTagsByField($table, $field, $uid);
        }

        return $tags;
    }

    protected function getTagFields(string $table): array
    {
        if (empty($GLOBALS['TCA'][$table]['columns'])) {
            return [];
        }

        $tagFields = [];
        foreach ($GLOBALS['TCA'][$table]['columns'] as $field => $configuration) {
            if (!$this->isTaggableField($table, $field)) {
                continue;
            }

            $tagFields[] = $field;
        }

        return $tagFields;
    }

    protected function isTaggableField(string $table, string $field): bool
    {
        if (empty($GLOBALS['TCA'][$table]['columns'][$field]['config'])) {
            return false;
        }

        $configuration = $GLOBALS['TCA'][$table]['columns'][$field]['config'];

        return ($configuration['type'] ?? '') === 'group'
            && ($configuration['allowed'] ?? '') === 'tx_t3tags_tag'
            && ($configuration['foreign_table'] ?? '') === 'tx_t3tags_tag'
            && ($configuration['MM'] ?? '') === 'tx_t3tags_tag_mm';
    }
}
