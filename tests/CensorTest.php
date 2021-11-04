<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Denno\CensorTests;

use Denno\Censor\Censor;
use Denno\Censor\Exception\BoundaryException;
use Denno\Censor\Exception\UnknownStrategyException;
use Denno\Censor\Strategy\Full;
use Denno\Censor\Strategy\Iban;
use Denno\Censor\Strategy\Mail;
use Denno\Censor\Strategy\PersonName;
use Denno\Censor\Strategy\Phone;
use Denno\Censor\Strategy\PhoneShort;
use PHPUnit\Framework\TestCase;

final class CensorTest extends TestCase
{

    public function testAbstract_1()
    {
        $censored = Censor::censor('DasIstEinTest', 0, 3, 6, 9, 13);
        $this->assertEquals('Das***Ein****', $censored);
    }

    public function testAbstract_2()
    {
        $censored = Censor::censor('DasIstEinTest', 3, 6, 9, 13);
        $this->assertEquals('***Ist***Test', $censored);
    }

    public function testAbstract_3()
    {
        $censored = Censor::censor('foobar', 0, 1, 2, 3, 5);
        $this->assertEquals('f*o**r', $censored);
    }

    public function testFullStrategy_1()
    {
        $censored = Censor::censorOnStrategy('I am very secret!', Full::class);
        $this->assertEquals('*****************', $censored);
    }

    public function testFullStrategy_2()
    {
        $censored = Censor::censorOnStrategy('Iamverysecret!', Full::class);
        $this->assertEquals('**************', $censored);
    }

    public function testIBAN_1()
    {
        $censored = Censor::censorOnStrategy('DE89 3704 0044 0532 0130 00', Iban::class);
        $this->assertEquals('DE**37040044053201****', $censored);
    }

    public function testIBAN_2()
    {
        $censored = Censor::censorOnStrategy('DE89370400440532013000', Iban::class);
        $this->assertEquals('DE**37040044053201****', $censored);
    }

    public function testIBAN_3()
    {
        $censored = Censor::censorOnStrategy('NL91 ABNA 0417 1643 00', Iban::class);
        $this->assertEquals('NL**ABNA041716****', $censored);
    }

    public function testIBAN_4()
    {
        $censored = Censor::censorOnStrategy('NL91ABNA0417164300', Iban::class);
        $this->assertEquals('NL**ABNA041716****', $censored);
    }

    public function testMail_1()
    {
        $censored = Censor::censorOnStrategy('dennis@double-d.it', Mail::class);
        $this->assertEquals('den***@doubl***.it', $censored);
    }

    public function testMail_2()
    {
        $censored = Censor::censorOnStrategy('dennis.ditte@very-long-domain.local', Mail::class);
        $this->assertEquals('dennis.di***@very-long-dom***.local', $censored);
    }

    public function testMail_3()
    {
        $censored = Censor::censorOnStrategy('dan@aol.com', Mail::class);
        $this->assertEquals('da*@ao*.com', $censored);
    }

    public function testPhone_1()
    {
        $censored = Censor::censorOnStrategy('015226215421', Phone::class);
        $this->assertEquals('015226215***', $censored);
    }

    public function testPhone_2()
    {
        $censored = Censor::censorOnStrategy('+4915226215421', Phone::class);
        $this->assertEquals('+4915226215***', $censored);
    }

    public function testPhone_3()
    {
        $censored = Censor::censorOnStrategy('055343124', Phone::class);
        $this->assertEquals('055343***', $censored);
    }

    public function testPhoneShort_1()
    {
        $censored = Censor::censorOnStrategy('3124', PhoneShort::class);
        $this->assertEquals('31**', $censored);
    }

    public function testPhoneShort_2()
    {
        $censored = Censor::censorOnStrategy('588678', PhoneShort::class);
        $this->assertEquals('588***', $censored);
    }

    public function testPhoneShort_3()
    {
        $censored = Censor::censorOnStrategy('13345', PhoneShort::class);
        $this->assertEquals('133**', $censored);
    }

    public function testException_1()
    {
        $this->expectException(BoundaryException::class);
        Censor::censor('AbCdEfGhIjK', 0, 44);
    }

    public function testException_2()
    {
        $this->expectException(BoundaryException::class);
        Censor::censor('AbCdEfGhIjK', -4, 4);
    }

    public function testException_3()
    {
        $this->expectException(UnknownStrategyException::class);
        Censor::censorOnStrategy('This is a string', 'ThisClassDoesNotExist');
    }

    public function testPersonName_1()
    {
        $censored = Censor::censorOnStrategy('Jon', PersonName::class);
        $this->assertEquals('Jo*', $censored);
    }

    public function testPersonName_2()
    {
        $censored = Censor::censorOnStrategy('Jon Doe', PersonName::class);
        $this->assertEquals('Jo* Do*', $censored);
    }

    public function testPersonName_3()
    {
        $censored = Censor::censorOnStrategy('Jonathan', PersonName::class);
        $this->assertEquals('Jonat***', $censored);
    }

    public function testPersonName_4()
    {
        $censored = Censor::censorOnStrategy('Jonathan Earl Of Northumbria', PersonName::class);
        $this->assertEquals('Jonat*** Ear* O* Northumb***', $censored);
    }

    public function testPersonName_5()
    {
        $censored = Censor::censorOnStrategy('Jonathan-Peter Earl Of Northumbria', PersonName::class);
        $this->assertEquals('Jonat***-Pe*** Ear* O* Northumb***', $censored);
    }

    public function testPersonName_6()
    {
        $censored = Censor::censorOnStrategy('Wilberg-Bückeburg', PersonName::class);
        $this->assertEquals('Wilb***-Bückeb***', $censored);
    }

    public function testPersonName_7()
    {
        $censored = Censor::censorOnStrategy('Miller & Justice', PersonName::class);
        $this->assertEquals('Mil*** & Just***', $censored);
    }
}