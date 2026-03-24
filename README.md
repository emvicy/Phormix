# Phormix

a PHP HTML-Forms Checker, Validator, Sanitizer module for Emvicy2 (2.x) PHP Framework: https://github.com/emvicy/Emvicy/tree/2.x

## Overview

- [Installation](#Installation)
- [Usage](#Usage)
  - [1. declare Form Elements](#1)
    - [1.1 Examples](#1-1) 
  - [2. declare a `formular.yaml`](#2)
  - [3. run Phormix inside of your Controller method](#3)

---

## Installation <a id="Installation"></a>

_cd into the modules folder of your `Emvicy` copy; e.g.:_
~~~bash
cd /var/www/html/modules/;
~~~

_clone `Phormix`_
~~~bash
git clone --branch 1.x https://github.com/emvicy/Phormix.git Phormix;
~~~

---

## Usage <a id="Usage"></a>

### 1. declare Form Elements <a id="1"></a>

declare all distinct elements of your formular in a single `yaml` file.  
Put all your `yaml` files in a separate folder.

Each declaration...

should have:

- `label`: (string)

must have: 

- `tag`: `input`|`select`|`textarea`
- `attribute`: (array)

may have:

- `filter`:
    - `validate`:
    - `sanitize`:


#### 1.1 Examples <a id="1-1"></a>

_`MAX_FILE_SIZE.yaml`_
~~~yaml
label: MAX_FILE_SIZE
tag: input
attribute:
  type: hidden
  name: MAX_FILE_SIZE
  value: 10485760 # Bytes; equals to 10 MB
  required: true
~~~

_`Country.yaml`_
~~~yaml
label: &element.Country.label Country
tag: select
attribute:
  form: *form.id
  id: &element.Country.attribute.id Country
  name: *element.Country.attribute.id
  autofocus: false
  #autocomplete: false
  required: true
  disabled: false
  multiple: true
  size: 1 # amount to display
filter:
  validate:
    minLength:
      value: 2
      message:
        fail: Please enter at least %s characters.
        success: You have successfully made all the necessary information for this purpose.
    expect:
      value:
        - label: Germany
          value: DE
        - label: England
          value: GB
        - label: Netherlands
          value: NL
      message:
        fail: Invalid entry.
        success: You made a valid entry.
    empty:
      value: false
      message:
        fail: This field can not be empty. Please fill in.
    regex:
      value: "/^[\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u"
      message:
        fail: Your entry includes not authorized characters
        success: Your entry includes only authorized characters.
  sanitize:
    maxlength:
      value: 2
    regex:
      value: "/[^\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u"
~~~

see folder `Phormix/element` for all examples.

---

### 2. declare a `formular.yaml` <a id="2"></a>

here you declare your formular and which elements it contains.

_`formular.yaml`_
~~~yaml
form:
  id: &form.id Profile # get the id by calling "*form.id"
  name: Profile
  action: ""
  method: post
#  enctype: ''
element:
  # names have to match to existing equal named files (without suffix) in $_sElementDirectory
  - MAX_FILE_SIZE
  - Salutation
  - Firstname
  - Surname
  - Company
  - Street
  - Postcode
  - City
  - State
  - Country
  - Telephone
  - Fax
  - Mobile
  - Email
  - Description
  - Message
~~~
- names beneath `element` have to match to existing equal named files (without suffix) in the Element Directory

---

### 3. run Phormix inside of your Controller method <a id="3"></a>

_Inside of your Controller method_  
~~~php
// start
$oPhormix = Phormix::init()
    // dir with form elements as "yaml" files
    ->setElementDirectory('/path/to/element/dir/')
    // formular config yaml file
    ->loadConfigYaml('/path/to/formular.yaml')
    // set a Validate Class that fits your needs
    ->setValidateClass('\Phormix\Model\PhormixValidate')
    ->run();
;

// form was successfully sent + validated
if (true === $oPhormix->bSuccess)
{
    // get Data
    $aFormData = $oPhormix->getDataAccepted()
}

// assign to view
view()->assign('oPhormix', $oPhormix);
view()->assign('oDTRoute', $oDTRoute);

view()->autoAssign();
~~~

---

### Templating

#### auto-creating a html formular

_`modules/Phormix/templates/phormix/phormix_formular.tpl`_    
~~~html
<!--form-->
{if false === $oPhormix->bSuccess}
    <form {$oPhormix->getMarkupFormAttributes()}>      
        {$oPhormix->getMarkupFormIdentifier()}
        {$oPhormix->getMarkupTicket()}      
        {foreach item=element from=$oPhormix->aConfig.element}
            <div class="mb-3">
                {if 'input' === $element.tag}
                    {if 'checkbox' === $element.attribute.type}
                        {include file="phormix/phormix_input_checkbox.tpl"}
                    {elseif 'radio' === $element.attribute.type}
                        {include file="phormix/phormix_input_radio.tpl"}
                    {elseif 'hidden' === $element.attribute.type}
                        {include file="phormix/phormix_input_hidden.tpl"}
                    {else}
                        {include file="phormix/phormix_input_default.tpl"}
                    {/if}
                {elseif 'select' === $element.tag}
                    {include file="phormix/phormix_select.tpl"}
                {elseif 'textarea' === $element.tag}
                    {include file="phormix/phormix_textarea.tpl"}
                {/if}
            </div>
        {/foreach}
        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
    </form>
{/if}
<!--/form-->
~~~

---

#### Messages

**Errors**

- when something went wrong

~~~html
{if false === empty($oPhormix->getErrorArray())}
    <!--error-->
    <ul class="feedback-message error-message">
        {foreach key=sKey item=sItem from=$oPhormix->getErrorArray()}
            {if !is_array($sItem)}<li>{$sItem|escape}</li>{/if}
        {/foreach}
    </ul>
    <!--/error-->
{/if}
~~~

**Missings**

- if e.g. an element is marked as `required` but was not sent

~~~html
{if false === empty($oPhormix->getMissingArray())}
    <!--missing-->
    <ul class="feedback-message error-message">
        {foreach key=sKey item=sItem from=$oPhormix->getMissingArray()}
            <li>
                Missing: "{$sItem.label|escape}"
            </li>
        {/foreach}
    </ul>
    <!--/missing-->
{/if}
~~~