<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzcloud;

use Craft;
use putyourlightson\blitz\drivers\storage\DummyStorage;

/**
 * The cache storage method for Craft Cloud essentially is a dummy, since cache
 * storage is handled by Cloudflare.
 */
class CloudStorage extends DummyStorage
{
    use CloudTrait;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Craft Cloud Storage');
    }

    /**
     * @inerhitdoc
     */
    public bool $isDummy = false;
}
