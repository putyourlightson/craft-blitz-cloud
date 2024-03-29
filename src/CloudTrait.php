<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use craft\cloud\Helper;
use craft\helpers\Html;

trait CloudTrait
{
    /**
     * Returns the component’s settings HTML.
     */
    public function getSettingsHtml(): ?string
    {
        $settingsHtml = '';

        if (!Helper::isCraftCloud()) {
            $settingsHtml = Html::ul(
                [Craft::t('blitz-cloud', 'This component can only be used on Craft Cloud.')],
                ['class' => 'errors'],
            );
        }

        return $settingsHtml . parent::getSettingsHtml();
    }
}
