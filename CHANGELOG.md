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