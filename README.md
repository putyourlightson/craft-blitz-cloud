[![Stable Version](https://img.shields.io/packagist/v/putyourlightson/craft-blitz-cloud?label=stable)]((https://packagist.org/packages/putyourlightson/craft-blitz-cloud))
[![Total Downloads](https://img.shields.io/packagist/dt/putyourlightson/craft-blitz-cloud)](https://packagist.org/packages/putyourlightson/craft-blitz-cloud)

<p align="center"><img width="130" src="https://raw.githubusercontent.com/putyourlightson/craft-blitz-cloud/v1/src/icon.svg"></p>

# Blitz Cloud Adapter Plugin for Craft Cloud

The Blitz Cloud Adapter allows the [Blitz](https://putyourlightson.com/plugins/blitz) plugin for [Craft CMS](https://craftcms.com/) to work with sites running on [Craft Cloud](https://craftcms.com/cloud).

## License

This plugin requires a free commercial license available through the [Craft Plugin Store](https://plugins.craftcms.com/blitz-cloud).

## Requirements

This plugin requires [Craft CMS](https://craftcms.com/) 4.6.0 or later, [Blitz](https://putyourlightson.com/plugins/blitz) 4.15.0 or later, and [Craft Cloud Extension](https://github.com/craftcms/cloud-extension-yii2/) 1.45.0 or later.

## Installation

To install the plugin, search for “Blitz Cloud Adapter” in the Craft Plugin Store, or install manually using composer.

```shell
composer require putyourlightson/craft-blitz-cloud
```

## Usage

Once installed, the following components should be selected in the Blitz plugin settings:

- **Cache Storage**: `Craft Cloud Storage`
- **Cache Generator**: `Craft Cloud Generator`
- **Reverse Proxy Purger**: `Craft Cloud Purger`

Note that the Blitz Cloud Adapter leverages Cloudflare’s edge cache, meaning that it will only be effective when running on Craft Cloud.

---

Created by [PutYourLightsOn](https://putyourlightson.com/).
