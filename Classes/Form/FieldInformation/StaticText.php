<?php

declare(strict_types=1);

namespace IchHabRecht\T3tags\Form\FieldInformation;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Localization\LanguageService;

class StaticText extends AbstractNode
{
    /**
     * Handler for single nodes
     *
     * @return array
     */
    public function render(): array
    {
        $languageService = $this->getLanguageService();

        $labels = [];
        foreach ((array)$this->data['renderData']['fieldInformationOptions']['labels'] as $labelConfiguration) {
            $label = htmlspecialchars($languageService->sL($labelConfiguration['label']));
            if (!empty($labelConfiguration['italic'])) {
                $label = '<em>' . $label . '</em>';
            }
            if (!empty($labelConfiguration['bold'])) {
                $label = '<strong>' . $label . '</strong>';
            }
            $labels[] = $label;
        }

        return [
            'requireJsModules' => [
                'TYPO3/CMS/T3tags/T3tagsGroupSuggestWizard',
            ],
            'html' => '<div class="form-control-wrap t3tags-taggable">'
                . implode('<br />', $labels)
                . '</div>',
        ];
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
