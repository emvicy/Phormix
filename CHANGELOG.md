# Changelog

- All notable changes to this project will be documented in this file.
- The format is based on [Keep a Changelog](https://keepachangelog.com/de/1.0.0/)
- This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

**added**

- `\Phormix\DataType\DTPhormixSetup`: contains setup config
- `\Phormix\Model\PhormixChain`: enabling chained forms

**changed**    

- `\Phormix\Model\Phormix::init`: 
  - Multiton instead of Singleton
  - add parameter `DTPhormixSetup $oDTPhormixSetup` 
- Yaml element: `explain` => `description`

**deprecated**
**removed**  

- `\Phormix\Model\Phormix::$_sElementDirectory`
- `\Phormix\Model\Phormix::setElementDirectory`
- `\Phormix\Model\Phormix::$_sValidateClass`
- `\Phormix\Model\Phormix::setValidateClass`
- `\Phormix\Model\Phormix::$_sSanitizeClass`
- `\Phormix\Model\Phormix::setSanitizeClass`
- `\Phormix\Model\PhormixSanitize`

**fixed**  
**security**