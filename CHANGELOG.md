# Changelog


## [v0.9.8](https://github.com/nfaiz/dbtoolbar/compare/v0.9.7...v0.9.8) - 2022-10-01

### Changed
- Add config files to skip editing Toolbar.php and Events.php manually. See upgrading in README.
- Change default theme.


## [v0.9.7](https://github.com/nfaiz/dbtoolbar/compare/v0.9.6...v0.9.7) - 2022-01-22

### Enhancement
- Add support to CodeIgniter 4.1.7.


## [v0.9.6](https://github.com/nfaiz/dbtoolbar/compare/v0.9.5...v0.9.6) - 2022-01-04

### Enhancement
- Add support to CodeIgniter 4.1.6.


## [v0.9.5](https://github.com/nfaiz/dbtoolbar/compare/v0.9.4...v0.9.5) - 2021-11-10

### Enhancement
- Add support to CodeIgniter 4.1.5.


## [v0.9.4](https://github.com/nfaiz/dbtoolbar/compare/v0.9.3...v0.9.4) - 2021-08-15

### Changed
- Manually set query collector for `DBQuery` events.
- Moved `$logger` from `DbToolbar.php` to `Toolbar.php`.

### Removed
- `DbToolbar.php` config file.


## [v0.9.3](https://github.com/nfaiz/dbtoolbar/compare/v0.9.2...v0.9.3) - 2021-08-06

### Enhancement
- Add logging using `$logger`. See [configuration](readme.md#configuration).


## [v0.9.2](https://github.com/nfaiz/dbtoolbar/compare/v0.9.1...v0.9.2) - 2021-07-26

### Changed
Property name in `app/Config/Toolbar.php` from
1. `$sqlMarginBottom` to `$queryMarginBottom` 
2. `$cssSqlTheme` to `$queryTheme` 

### Others
- Code refactor.


## [v0.9.1](https://github.com/nfaiz/dbtoolbar/compare/v0.9.0...v0.9.1) - 2021-07-24

### Changed
- Moved `$sqlMarginBottom` from `DbToolbar.php` to `Toolbar.php`.


## [v0.9.0](https://github.com/nfaiz/dbtoolbar/releases/tag/v0.9.0) - 2021-07-25

### Added
- Initial pre-release.
