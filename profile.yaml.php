<?php

$aConfig = array (
  'form' => 
  array (
    'id' => 'Profile',
    'name' => 'Profile',
    'action' => '',
    'method' => 'post',
  ),
  'element' => 
  array (
    0 => 
    array (
      'label' => 'MAX_FILE_SIZE',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'hidden',
        'name' => 'MAX_FILE_SIZE',
        'value' => '10485760',
        'required' => true,
      ),
    ),
    1 =>
    array (
      'label' => 'Salutation / Gender',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'radio',
        'id' => 'Salutation',
        'name' => 'Salutation',
        'value' => '',
        'title' => 'Salutation / Gender',
        'placeholder' => 'Salutation / Gender',
        'minLength' => 2,
        'maxlength' => 10,
        'autofocus' => true,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 2,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'expect' => 
          array (
            'value' => 
            array (
              0 => 
              array (
                'label' => 'Mr',
                'value' => 'Mr',
              ),
              1 => 
              array (
                'label' => 'Mrs',
                'value' => 'Mrs',
              ),
              2 => 
              array (
                'label' => 'unspecific',
                'value' => 'unspecific',
              ),
            ),
            'message' => 
            array (
              'fail' => 'Invalid entry.',
              'success' => 'You made a valid entry.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 10,
            'message' => 
            array (
              'fail' => 'The maximum length is %s characters . The input was reduced accordingly.',
              'success' => 'The maximum length of % s characters has not been exceeded.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/[^\\p{L}\\p{Zs}]/u',
            'message' => 
            array (
              'fail' => 'Disvalued characters removed.',
              'success' => 'The entry must not be cleaned.',
            ),
          ),
        ),
      ),
    ),
    2 => 
    array (
      'label' => 'Firstname',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Firstname',
        'name' => 'Firstname',
        'value' => '',
        'title' => 'Firstname',
        'placeholder' => 'Firstname',
        'minLength' => 3,
        'maxlength' => 50,
        'autofocus' => false,
        'required' => false,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 50,
            'message' => 
            array (
              'fail' => 'The maximum length is %s characters. The input was reduced accordingly.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/[^\\p{L}\\p{Zs}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.]/u',
            'message' => 
            array (
              'fail' => 'Disvalued characters removed.',
            ),
          ),
        ),
      ),
    ),
    3 => 
    array (
      'label' => 'Surname',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Surname',
        'name' => 'Surname',
        'value' => '',
        'title' => 'Surname',
        'placeholder' => 'Surname',
        'minLength' => 3,
        'maxlength' => 50,
        'autofocus' => true,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 50,
          ),
          'regex' => 
          array (
            'value' => '/[^\\p{L}\\p{Zs}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u',
          ),
        ),
      ),
    ),
    4 => 
    array (
      'label' => 'Company',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Company',
        'name' => 'Company',
        'value' => '',
        'title' => 'Company',
        'placeholder' => 'Company',
        'minLength' => 3,
        'maxlength' => 50,
        'autofocus' => false,
        'required' => false,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,?!&]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 50,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,?!&]/u',
          ),
        ),
      ),
    ),
    5 => 
    array (
      'label' => 'Street / Nr',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Street',
        'name' => 'Street',
        'value' => '',
        'title' => 'Street / Nr',
        'placeholder' => 'Street / Nr',
        'minLength' => 3,
        'maxlength' => 50,
        'autofocus' => false,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have successfully made all the necessary information for this purpose.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 50,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u',
          ),
        ),
      ),
    ),
    6 => 
    array (
      'label' => 'Postcode',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Postcode',
        'name' => 'Postcode',
        'value' => '',
        'title' => 'Postcode',
        'placeholder' => 'Postcode',
        'minLength' => 3,
        'maxlength' => 5,
        'autofocus' => false,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have successfully made all the necessary information for this purpose.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{Nd}.#]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 5,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{L}\\p{Zs}\\p{Nd}.#]/u',
          ),
        ),
      ),
    ),
    7 => 
    array (
      'label' => 'City',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'City',
        'name' => 'City',
        'value' => '',
        'title' => 'City',
        'placeholder' => 'City',
        'minLength' => 3,
        'maxlength' => 50,
        'autofocus' => false,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have successfully made all the necessary information for this purpose.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 50,
          ),
          'regex' => 
          array (
            'value' => '/[^\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u',
          ),
        ),
      ),
    ),
    8 => 
    array (
      'label' => 'State',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'State',
        'name' => 'State',
        'value' => '',
        'title' => 'State',
        'placeholder' => 'State',
        'minLength' => 3,
        'maxlength' => 50,
        'autofocus' => false,
        'required' => false,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have successfully made all the necessary information for this purpose.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 50,
          ),
          'regex' => 
          array (
            'value' => '/[^\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u',
          ),
        ),
      ),
    ),
    9 => 
    array (
      'label' => 'Telephone',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Telephone',
        'name' => 'Telephone',
        'value' => '',
        'title' => 'Telephone',
        'placeholder' => 'Telephone',
        'minLength' => 1,
        'maxlength' => 25,
        'autofocus' => false,
        'required' => false,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 1,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{Nd}\\p{Zs}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 25,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{Zs}\\p{Nd}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u',
          ),
        ),
      ),
    ),
    10 => 
    array (
      'label' => 'Fax',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Fax',
        'name' => 'Fax',
        'value' => '',
        'title' => 'Fax',
        'placeholder' => 'Fax',
        'minLength' => 3,
        'maxlength' => 25,
        'autofocus' => false,
        'required' => false,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 3,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{Nd}\\p{Zs}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 25,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{Zs}\\p{Nd}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.]/u',
          ),
        ),
      ),
    ),
    11 => 
    array (
      'label' => 'Mobile',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Mobile',
        'name' => 'Mobile',
        'value' => '',
        'title' => 'Mobile',
        'placeholder' => 'Mobile',
        'minLength' => 1,
        'maxlength' => 25,
        'autofocus' => false,
        'required' => false,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'minLength' => 
          array (
            'value' => 1,
            'message' => 
            array (
              'fail' => 'Please enter at least %s characters.',
              'success' => 'You have specified more than the required minimum amount of %s characters.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
            'message' => 
            array (
              'fail' => 'This field can not be empty. Please fill in.',
            ),
          ),
          'regex' => 
          array (
            'value' => '/^[\\p{Nd}\\p{Zs}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]+$/u',
            'message' => 
            array (
              'fail' => 'Your entry includes not authorized characters',
              'success' => 'Your entry includes only authorized characters.',
            ),
          ),
        ),
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 25,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{Zs}\\p{Nd}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}.,]/u',
          ),
        ),
      ),
    ),
    12 => 
    array (
      'label' => 'E-mail address',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Email',
        'name' => 'Email',
        'value' => '',
        'title' => 'E-mail address of the form: example@example.de',
        'placeholder' => 'E-mail address',
        'minLength' => 5,
        'maxlength' => 255,
        'autofocus' => false,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'validate' => 
        array (
          'email' => 
          array (
            'value' => 
            array (
              'checkMX' => true,
              'checkUserExists' => false,
            ),
            'message' => 
            array (
              'fail' => 'The given e-mail address is not valid.',
            ),
          ),
          'empty' => 
          array (
            'value' => false,
          ),
        ),
        'sanitize' => 
        array (
          'email' => 
          array (
            'value' => true,
          ),
        ),
      ),
    ),
    13 => 
    array (
      'label' => 'Description',
      'tag' => 'input',
      'attribute' => 
      array (
        'type' => 'text',
        'id' => 'Description',
        'name' => 'Description',
        'value' => '',
        'title' => 'Description',
        'placeholder' => 'Description',
        'minLength' => 3,
        'maxlength' => 2000,
        'autofocus' => false,
        'required' => true,
        'disabled' => false,
      ),
      'filter' => 
      array (
        'sanitize' => 
        array (
          'maxlength' => 
          array (
            'value' => 2000,
          ),
          'regex' => 
          array (
            'value' => '/[^\\w\\d\\p{L}\\p{Zs}\\p{Nd}\\p{M}\\p{Pd}\\p{Ps}\\p{Pe}\\p{Pc}&,.?!]/u',
          ),
        ),
      ),
    ),
    14 => 
    array (
      'label' => 'Message',
      'tag' => 'textarea',
      'attribute' => 
      array (
        'type' => 'text',
        'rows' => 3,
        'cols' => 3,
        'id' => 'Message',
        'name' => 'Message',
        'value' => '',
        'title' => 'Message',
        'placeholder' => 'Message',
        'minLength' => 3,
        'maxlength' => 2000,
        'autofocus' => false,
        'required' => true,
        'disabled' => false,
      ),
    ),
  ),
);