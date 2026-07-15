# Changelog

## [Unreleased]

**added**
**changed**    
**deprecated**
**removed**  
**fixed**  
**security**

------------------------------------------------------------------------------------------------------------------------

## [Released]

### [1.3.2] - 2026-07-15, https://github.com/emvicy/Phormix/releases/tag/1.3.2

**changed**

- `templates/phormix/phormix_input_radio.tpl`: skip multiple autofocus attributes for type radio
- `templates/phormix/phormix_*.tpl`: If an attribute value (bool) is true, then include only the attribute in the HTML tag context – without the value (e.g. autofocus; instead of autofocus="1")

---

### [1.3.1] - 2026-07-14, https://github.com/emvicy/Phormix/releases/tag/1.3.1

**changed**

- `element/Telephone|Fax|Mobile.yaml`: regex pattern for frontend + backend validation
- `element/Password.yaml`: add regex pattern for frontend + backend validation and its description

**fixed**

- `\Phormix\Model\PhormixValidate::_REGEX`: if value is empty, regex on empty makes no sense; return true

---

### [1.3] - 2026-04-21, https://github.com/emvicy/Phormix/releases/tag/1.3

**added**

- `\Phormix\Model\PhormixValidate::_URL`
- `element/TermsOfUse.yaml`
- `element/Website.yaml`

**changed**

- `\Phormix\Model\PhormixChain::setActionOnRoutePath`: param#1 from `DTRoute $oDTRoute` => to => `string $sPath`

**fixed**

- `\Phormix\Model\PhormixChain::getStep`/`\Phormix\Model\PhormixChain::getPhormix`: possible to call steps that do not exist; Fix: prevent depending on chain array size

---

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