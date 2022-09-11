<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':Attribute musí být přijat.',
    'accepted_if' => 'Attribute musí být přijat pokud :other je :value.',
    'active_url' => ':Attribute není platnou URL adresou.',
    'after' => ':Attribute musí být datum po :date.',
    'after_or_equal' => ':Attribute musí být datum :date nebo pozdější.',
    'alpha' => ':Attribute může obsahovat pouze písmena.',
    'alpha_dash' => ':Attribute může obsahovat pouze písmena, číslice, pomlčky a podtržítka. České znaky (á, é, í, ó, ú, ů, ž, š, č, ř, ď, ť, ň) nejsou podporovány.',
    'alpha_num' => ':Attribute může obsahovat pouze písmena a číslice.',
    'array' => ':Attribute musí být pole.',
    'before' => ':Attribute musí být datum před :date.',
    'before_or_equal' => 'Datum :attribute musí být před nebo rovno :date.',
    'between' => [
        'array' => ':Attribute musí obsahovat nejméně :min a nesmí obsahovat více než :max prvků.',
        'file' => ':Attribute musí být větší než :min a menší než :max Kilobytů.',
        'numeric' => ':Attribute musí být hodnota mezi :min a :max.',
        'string' => ':Attribute musí být delší než :min a kratší než :max znaků.',
    ],
    'boolean' => ':Attribute musí být ano nebo ne.',
    'confirmed' => ':Attribute nesouhlasí.',
    'current_password' => 'Současné heslo není spravné.',
    'date' => ':Attribute musí být platné datum.',
    'date_equals' => ':Attribute musí být datum shodné s :date.',
    'date_format' => ':Attribute není platný formát data podle :format.',
    'declined' => ':Attribute musí být odmítnut.',
    'declined_if' => ':Attribute musí být odmítnut pokud :other je :value.',
    'different' => ':Attribute a :other se musí lišit.',
    'digits' => ':Attribute musí být :digits pozic dlouhé.',
    'digits_between' => ':Attribute musí být dlouhé nejméně :min a nejvíce :max pozic.',
    'dimensions' => ':Attribute má neplatné rozměry.',
    'distinct' => ':Attribute má duplicitní hodnotu.',
    'doesnt_end_with' => 'The :attribute may not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute may not start with one of the following: :values.',
    'email' => ':Attribute není platný formát.',
    'ends_with' => ':Attribute musí končit jednou z následujících hodnot: :values.',
    'enum' => 'Zvolená hodnota pro :attribute je neplatná.',
    'exists' => 'Zvolená hodnota pro :attribute není platná.',
    'file' => ':Attribute musí být soubor.',
    'filled' => ':Attribute musí být vyplněno.',
    'gt' => [
        'array' => 'Pole :attribute musí mít více prvků než :value.',
        'file' => 'Velikost souboru :attribute musí být větší než :value kB.',
        'numeric' => ':Attribute musí být větší než :value.',
        'string' => 'Počet znaků :attribute musí být větší :value.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí mít :value prvků nebo více.',
        'file' => 'Velikost souboru :attribute musí být větší nebo rovno :value kB.',
        'numeric' => ':Attribute musí být větší nebo rovno :value.',
        'string' => 'Počet znaků :attribute musí být větší nebo rovno :value.',
    ],
    'image' => ':Attribute musí být obrázek.',
    'in' => 'Zvolená hodnota pro :attribute je neplatná.',
    'in_array' => ':Attribute není obsažen v :other.',
    'integer' => ':Attribute musí být celé číslo.',
    'ip' => ':Attribute musí být platnou IP adresou.',
    'ipv4' => ':Attribute musí být platná IPv4 adresa.',
    'ipv6' => ':Attribute musí být platná IPv6 adresa.',
    'json' => ':Attribute musí být platný JSON řetězec.',
    'lt' => [
        'array' => ':Attribute by měl obsahovat méně než :value položek.',
        'file' => 'Velikost souboru :attribute musí být menší než :value kB.',
        'numeric' => ':Attribute musí být menší než :value.',
        'string' => ':Attribute musí obsahovat méně než :value znaků.',
    ],
    'lte' => [
        'array' => ':Attribute by měl obsahovat maximálně :value položek.',
        'file' => 'Velikost souboru :attribute musí být menší než :value kB.',
        'numeric' => ':Attribute musí být menší nebo rovno než :value.',
        'string' => ':Attribute nesmí být delší než :value znaků.',
    ],
    'mac_address' => ':Attribute není platnou MAC adresou.',
    'max' => [
        'array' => ':Attribute nemůže obsahovat více než :max prvků.',
        'file' => 'Velikost souboru :attribute musí být menší než :value kB.',
        'numeric' => ':Attribute nemůže být větší než :max.',
        'string' => ':Attribute nemůže být delší než :max znaků.',
    ],
    'max_digits' => 'The :attribute must not have more than :max digits.',
    'mimes' => ':Attribute musí být jeden z následujících datových typů :values.',
    'mimetypes' => ':Attribute musí být jeden z následujících datových typů :values.',
    'min' => [
        'array' => ':Attribute musí obsahovat více než :min prvků.',
        'file' => ':Attribute musí být větší než :min kB.',
        'numeric' => ':Attribute musí být větší než :min.',
        'string' => ':Attribute musí být delší než :min znaků.',
    ],
    'min_digits' => 'The :attribute must have at least :min digits.',
    'multiple_of' => ':Attribute musí být násobkem :value.',
    'not_in' => 'Zvolená hodnota pro :attribute je neplatná.',
    'not_regex' => ':Attribute musí být regulární výraz.',
    'numeric' => ':Attribute musí být číslo.',
    'password' => [
        'letters' => ':Attribute musí obsahovat alespoň jedno písmeno.',
        'mixed' => ':Attribute musí obsahovat alespoň jedno velké a jedno malé písmeno.',
        'numbers' => ':Attribute musí obsahovat alespoň jedno číslo.',
        'symbols' => ':Attribute musí obsahovat alespoň jeden speciální znak.',
        'uncompromised' => 'Daný :attribute se objevil v úniku dat. Zvolte prosím jiný :attribute.',
    ],
    'present' => ':Attribute musí být vyplněno.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => 'Pole :attribute je zakázáno, když je :other :value.',
    'prohibited_unless' => 'Pole :attribute je zakázáno, pokud není rok :other v roce :values.',
    'prohibits' => 'Pole :attribute zakazuje vyplňovat :other.',
    'regex' => ':Attribute nemá správný formát.',
    'required' => ':Attribute musí být vyplněno.',
    'required_array_keys' => 'Pole :attribute musí obsahovat položky pro: :values.',
    'required_if' => ':Attribute musí být vyplněno pokud :other je :value.',
    'required_unless' => ':Attribute musí být vyplněno dokud :other je v :values.',
    'required_with' => ':Attribute musí být vyplněno pokud :values je vyplněno.',
    'required_with_all' => ':Attribute musí být vyplněno pokud :values je zvoleno.',
    'required_without' => ':Attribute musí být vyplněno pokud :values není vyplněno.',
    'required_without_all' => ':Attribute musí být vyplněno pokud není žádné z :values zvoleno.',
    'same' => ':Attribute a :other se musí shodovat.',
    'size' => [
        'array' => ':Attribute musí obsahovat právě :size prvků.',
        'file' => ':Attribute musí mít přesně :size Kilobytů.',
        'numeric' => ':Attribute musí být přesně :size.',
        'string' => ':Attribute musí být přesně :size znaků dlouhý.',
    ],
    'starts_with' => ':Attribute musí začínat jednou z následujících hodnot: :values.',
    'string' => ':Attribute musí být řetězec znaků.',
    'timezone' => ':Attribute musí být platná časová zóna.',
    'unique' => ':Attribute musí být unikátní.',
    'uploaded' => 'Nahrávání :attribute se nezdařilo.',
    'url' => 'Formát :attribute je neplatný.',
    'uuid' => ':Attribute musí být validní UUID.',

    'prohibited_with' => 'Pole :attribute je zakázáno pokud :values je vyplněno.',
    'prohibited_with_all' => 'Pole :attribute je zakázáno pokud :values je zvoleno.',
    'prohibited_without' => 'Pole :attribute je zakázáno pokud :values není vyplněno.',
    'prohibited_without_all' => 'Pole :attribute je zakázáno pokud není žádné z :values zvoleno.',
    'null_with' => 'Pole :attribute je zakázáno pokud :values je vyplněno.',
    'null_with_all' => 'Pole :attribute je zakázáno pokud :values je zvoleno.',
    'null_without' => 'Pole :attribute je zakázáno pokud :values není vyplněno.',
    'null_without_all' => 'Pole :attribute je zakázáno pokud není žádné z :values zvoleno.',
    'strlen' => ':Attribute musí být přesně :size znaků dlouhý.',
    'strlen_max' => ':Attribute nemůže být delší než :max znaků.',
    'strlen_min' => ':Attribute musí být delší než :min znaků.',
    'null' => 'Pole :attribute je zakázáno.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        '*' => 'položka',
        'remember' => 'zapamatovat přihlášení',
        'email' => 'e-mail',
        'password' => 'heslo',
        'token' => 'kód',
        'new_password' => 'nové heslo',
        'name' => 'jméno',
        'terms_accepted' => 'souhlas s podmínkami',
        'locale' => 'jazyk',
    ],
];
