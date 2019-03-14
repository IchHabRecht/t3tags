<?php
declare(strict_types = 1);
namespace IchHabRecht\T3tags\Form\Wizard;

use TYPO3\CMS\Backend\Form\Wizard\SuggestWizardDefaultReceiver;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\StringUtility;

class SuggestWizardReceiver extends SuggestWizardDefaultReceiver
{
    public function queryTable(&$params, $recursionCounter = 0)
    {
        $rows = parent::queryTable($params, $recursionCounter);

        $searchString = strtolower($params['value']);
        $matchRow = array_filter($rows, function ($value) use ($searchString) {
            return strtolower($value['label']) === $searchString;
        });

        if (empty($matchRow)) {
            $newUid = StringUtility::getUniqueId('NEW');
            $rows[$this->table . '_' . $newUid] = [
                'class' => '',
                'label' => $params['value'],
                'path' => '',
                'sprite' => $this->iconFactory->getIconForRecord($this->table, [], Icon::SIZE_SMALL)->render(),
                'style' => '',
                'table' => $this->table,
                'text' => sprintf($this->getLanguageService()->sL('LLL:EXT:t3tags/Resources/Private/Language/locallang_be.xlf:tx_t3tags_tag.create'), $params['value']),
                'uid' => $newUid,
            ];
            $pid = null;
            $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3tags'], ['allowed_classes' => false]);
            if (!empty($settings['tagPid'])) {
                $pid = $settings['tagPid'];
            } elseif (!empty($this->allowedPages)) {
                $pid = $this->allowedPages[0];
            }
            if ($pid !== null) {
                $rows[$this->table . '_' . $newUid]['pid'] = $pid;
            }
        }

        return $rows;
    }
}
