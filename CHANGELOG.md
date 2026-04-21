# Changelog

## [Unreleased]

**added**

- `\Phormix\Model\PhormixValidate::_URL`
- `element/TermsOfUse.yaml`
- `element/Website.yaml`

**changed**    

- `\Phormix\Model\PhormixChain::setActionOnRoutePath`: param#1 from `DTRoute $oDTRoute` => to => `string $sPath`

**deprecated**
**removed**  
**fixed**  

- `\Phormix\Model\PhormixChain::getStep`/`\Phormix\Model\PhormixChain::getPhormix`: possible to call steps that do not exist; Fix: prevent depending on chain array size 

**security**

------------------------------------------------------------------------------------------------------------------------

## [Released]

### [1.2] - 2026-04-18, https://github.com/emvicy/Phormix/releases/tag/1.2

**added**

- Events
  - `phormix.model.phormix._check.validate.fail`
  - `phormix.model.phormix._check.validate.success`
- `element/Password.yaml`
- `\Phormix\DataType\DTPhormixSetup::$sMandatoryCode`
  - use `DTPhormixSetup::create()->set_sMandatoryCode('*')` to set
  - use `{$oPhormix->getDTPhormixSetup()->get_sMandatoryCode()}` in template

**changed**

- `templates/phormix/phormix_*.tpl`: id attributes now start with an `id_` to avoid conflict with same named `name` attributes in Browser
- `element/*.yaml`: all `autofocus` set to `false`

**fixed**

- `modules/Phormix/templates/phormix/phormix_input_radio.tpl:28`: has to be `$data.value` instead of `$data.label`

---

### [1.1] - 2026-04-10, https://github.com/emvicy/Phormix/releases/tag/1.1

Key Features

- multi-page formular (chained forms) 

---

**added**

- `\Phormix\DataType\DTPhormixSetup`: contains setup config
- `\Phormix\Model\PhormixChain`: enabling chained forms

**changed**

- `\Phormix\Model\Phormix::init`:
  - Multiton instead of Singleton
  - add parameter `DTPhormixSetup $oDTPhormixSetup`
- Yaml element: `explain` => `description`

**removed**

- `\Phormix\Model\Phormix::$_sElementDirectory`
- `\Phormix\Model\Phormix::setElementDirectory`
- `\Phormix\Model\Phormix::$_sValidateClass`
- `\Phormix\Model\Phormix::setValidateClass`
- `\Phormix\Model\Phormix::$_sSanitizeClass`
- `\Phormix\Model\Phormix::setSanitizeClass`
- `\Phormix\Model\PhormixSanitize`