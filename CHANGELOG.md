# Changelog

## [Unreleased]

**added**

- `element/Password.yaml`
- `\Phormix\DataType\DTPhormixSetup::$sMandatoryCode`
  - use `DTPhormixSetup::create()->set_sMandatoryCode('*')` to set
  - use `{$oPhormix->getDTPhormixSetup()->get_sMandatoryCode()}` in template

**changed**    

- `templates/phormix/phormix_*.tpl`: id attributes now start with an `id_` to avoid conflict with same named `name` attributes in Browser  
- `element/*.yaml`: all `autofocus` set to `false`

**deprecated**
**removed**  
**fixed**  

- `modules/Phormix/templates/phormix/phormix_input_radio.tpl:28`: has to be `$data.value` instead of `$data.label`

**security**

------------------------------------------------------------------------------------------------------------------------

## [Released]

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