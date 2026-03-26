# Phormix

a PHP HTML-Forms Checker, Validator, Sanitizer module for Emvicy2 (2.x) PHP Framework: https://github.com/emvicy/Emvicy/tree/2.x

## Overview

- [Installation](#Installation)
- [Usage](#Usage)
  - [1. declare Form Elements](#1)
    - [1.1 Examples](#1-1) 
  - [2. declare a `formular.yaml`](#2)
  - [3. run Phormix inside of your Controller method](#3)
- [Demo](#Demo)

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

*`MAX_FILE_SIZE.yaml`*  
~~~yaml
label: MAX_FILE_SIZE
tag: input
attribute:
  type: hidden
  name: MAX_FILE_SIZE
  value: 10485760 # Bytes; equals to 10 MB
  required: true
~~~

_`Firstname.yaml`_
~~~yaml
label: &element.Firstname.label Firstname
tag: input
attribute:
  type: text
  id: &element.Firstname.attribute.id Firstname
  name: *element.Firstname.attribute.id
  value: ''
  title: *element.Firstname.label
  placeholder: *element.Firstname.label
  minLength: &element.Firstname.attribute.minLength 3
  maxlength: &element.Firstname.attribute.maxlength 50
  autofocus: false
  autocomplete: false
  required: false
  disabled: false
filter:
  validate:
    minLength:
      value: *element.Firstname.attribute.minLength
      message:
        fail: Please enter at least %s characters.
        success: You have specified more than the required minimum amount of %s characters.
    empty:
      value: false
      message:
        fail: This field can not be empty. Please fill in.
    regex:
      value: "/^[\\p{L}\\p{Zs}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.]+$/u"
      message:
        fail: Your entry includes not authorized characters
        success: Your entry includes only authorized characters.
  sanitize:
    maxlength:
      value: *element.Firstname.attribute.maxlength
      message:
        fail: The maximum length is %s characters. The input was reduced accordingly.
    regex:
      value: "/[^\\p{L}\\p{Zs}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.]/u"
      message:
        fail: Disvalued characters removed.
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
  # names have to match to existing equal named files (without suffix) in $_sElementDirectory (see /Phormix/element/)
  - MAX_FILE_SIZE
  - Salutation
  - Firstname
  - Surname
  - Company
  - Street
  - Postcode
  - City
  - Telephone
  - Email
  - Message
  - Captcha
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

*`modules/Phormix/templates/phormix/phormix_formular.tpl`*      
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
  <ul class="list-unstyled">
      {foreach key=sKey item=sItem from=$oPhormix->getErrorArray()}
          {if !is_array($sItem)}
          <li class="alert alert-danger">
              <a href="#{$sKey}">{$sItem|escape}</a>
          </li>
          {/if}
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
  <ul class="list-unstyled">
      {foreach key=sKey item=sItem from=$oPhormix->getMissingArray()}
      <li class="alert alert-warning">
          Missing: "{$sItem.label|escape}"
      </li>
      {/foreach}
  </ul>
  <!--/missing-->
{/if}
~~~

---

## Demo <a id="Demo"></a>

for a running Demo in your App, add the phormix routing folder by adding    
the following lines to your primary module config, .e.g.: `modules/Foo/etc/config/_mvc.php`.

*`modules/Foo/etc/config/_mvc.php`*    
~~~php
#-----------------------------------------------------------------------------------------------------------------------
# Phormix

// add Phormix routing dir
$aConfig['MVC_ROUTING_DIR'][] = realpath(__DIR__ . '/../../../') . '/Phormix/etc/routing';
~~~
- adjust the realpath if necessary

after that you can call the Route `/phormix/` in your Browser.

---

## License

**Font used for Captcha** 

- "Educational Gothic V2" (EducationalGothic-Regular.otf)
  - Copyright © XYZ Co. Inc.
  - Version 1.2.3.4
  - License: GNU General Public License v3.0 (see `etc/config/Phormix/config/Educational_Gothic_V2/LICENSE.txt`)