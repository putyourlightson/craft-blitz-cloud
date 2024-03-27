[![Stable Version](https://img.shields.io/packagist/v/putyourlightson/craft-blitz-cloud?label=stable)]((https://packagist.org/packages/putyourlightson/craft-blitz-cloud))
[![Total Downloads](https://img.shields.io/packagist/dt/putyourlightson/craft-blitz-cloud)](https://packagist.org/packages/putyourlightson/craft-blitz-cloud)

<p align="center"><img width="130" src="https://raw.githubusercontent.com/putyourlightson/craft-blitz-cloud/v1/src/icon.svg"></p>

# Blitz Cloud Purger Plugin for Craft CMS on Craft Cloud

The Cloud Purger plugin allows the [Blitz](https://putyourlightson.com/plugins/blitz) plugin for [Craft CMS](https://craftcms.com/) to intelligently purge pages cached by Craft Cloud.

## Documentation

Read the documentation at [putyourlightson.com/plugins/blitz »](https://putyourlightson.com/plugins/blitz#reverse-proxy-purgers)

## License

This plugin requires a free commercial license available through the [Craft Plugin Store](https://plugins.craftcms.com/blitz-cloud).

## Requirements

This plugin requires [Craft CMS](https://craftcms.com/) 4.6.0 or later.

## Installation

To install the plugin, search for “Blitz Cloud Purger” in the Craft Plugin Store, or install manually using composer.

```shell
composer require putyourlightson/craft-blitz-cloud
```

You can then select the purger and settings either in the control panel or in `config/blitz.php`.

```php
// The purger type to use.
'cachePurgerType' => 'putyourlightson\blitzcloud\CloudPurger',
```

---

Created by [PutYourLightsOn](https://putyourlightson.com/).
