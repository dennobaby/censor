[![Tests](https://github.com/dennobaby/censor/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/dennobaby/censor/actions/workflows/tests.yml)

# censor
Simple PHP-lib to censor sensible data

## Usage
```php
use Denno\Censor\Censor;

$censored = Censor::censor($string, ...$positions)
 // or
$censored = Censor::censorOnStrategy($string, Strategy::class);

```

## Strategies
Censor comes up with defined strategies for common data-types like IBAN, Phonenumbers, 
### IBAN
 This strategy is useful to censor bank-accounts in IBAN-Format. 
#### Examples
* DE89 3704 0044 0532 0130 00 => DE&ast;&ast;37040044053201&ast;&ast;&ast;&ast;
* NL91 ABNA 0417 1643 00 =>  NL&ast;&ast;ABNA041716&ast;&ast;&ast;&ast;

### Phone-Numbers
This strategy is useful to censor phone-numbers including area codes.
#### Examples
* +4915226215421 => +4915226215***

For short phone-numbers you should use the phone-short-strategy which censors the last half:
 * 300452 => 300***

### E-Mail
Simply censor parts from the username and the domain
#### Examples:
* dennis@double-d.it => den***@doubl***.it
* dan@aol.local => da*@ao*.local

### Person-Name
Censor a Person-name
#### Examples:
* Miller & Justice => Mil*** & Just***
* Jonathan Earl Of Northumbria => Jonat*** Ear* O* Northumb***
* Jon Doe => Jo* Do*

## Custom censoring
Define your own censoring schema by using directly the censor-function.
The first parameter is your string, the second is a variable number of positions, where up to the first position is censored, up to the second not, and so on.

## Custom strategies
You can write your own Strategy implementing StrategyInterface to define patterns Censor should use.