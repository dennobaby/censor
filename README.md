# censor
Simple PHP-lib to censor sensible data

## Usage
```php
use dennobaby\Censor\Censor;

[...]

$censored = Censor::censor($string, ...$positions)
 // or
$censored = Censor::censorOnStrategy($string, $strategy);

```

## Strategies
Censor comes up with defined strategies for common data-types like IBAN, Phonenumbers, 
 ### IBAN
 This strategy is useful to censor bank-accounts in IBAN-Format. 
 ####Examples:
* DE54 2545 0110 0031 0465 50 => DE&ast;&ast;25450110003104&ast;&ast;&ast;&ast;
* NL91 ABNA 0417 1643 00 =>  NL&ast;&ast;ABNA041716&ast;&ast;&ast;&ast;

### Phone-Numbers
This strategy is useful to censor long phone-numbers 