<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Censor\Tests;

use Censor\Censor;
use Censor\Exception\BoundaryException;
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../src/Censor.php";
require __DIR__ . "/../src/Exception/BoundaryException.php";

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
        $censored = Censor::censorOnStrategy('I am very secret!', Censor::STRATEGY_FULL);
        $this->assertEquals('**************', $censored);
    }

    public function testFullStrategy_2()
    {
        $censored = Censor::censorOnStrategy('Iamverysecret!', Censor::STRATEGY_FULL);
        $this->assertEquals('**************', $censored);
    }

    public function testIBAN_1()
    {
        $censored = Censor::censorOnStrategy('DE54 2545 0110 0031 0465 50', Censor::STRATEGY_IBAN);
        $this->assertEquals('DE**25450110003104****', $censored);
    }

    public function testIBAN_2()
    {
        $censored = Censor::censorOnStrategy('DE54254501100031046550', Censor::STRATEGY_IBAN);
        $this->assertEquals('DE**25450110003104****', $censored);
    }

    public function testIBAN_3()
    {
        $censored = Censor::censorOnStrategy('NL91 ABNA 0417 1643 00', Censor::STRATEGY_IBAN);
        $this->assertEquals('NL**ABNA041716****', $censored);
    }

    public function testIBAN_4()
    {
        $censored = Censor::censorOnStrategy('NL91ABNA0417164300', Censor::STRATEGY_IBAN);
        $this->assertEquals('NL**ABNA041716****', $censored);
    }

    public function testMail_1()
    {
        $censored = Censor::censorOnStrategy('dennis@double-d.it', Censor::STRATEGY_MAIL);
        $this->assertEquals('den***@doubl***.it', $censored);
    }

    public function testMail_2()
    {
        $censored = Censor::censorOnStrategy('dennis.ditte@united-promotion.eu', Censor::STRATEGY_MAIL);
        $this->assertEquals('dennis.di***@united-promot***.eu', $censored);
    }

    public function testMail_3()
    {
        $censored = Censor::censorOnStrategy('dan@aol.com', Censor::STRATEGY_MAIL);
        $this->assertEquals('da*@ao*.com', $censored);
    }

    public function testPhone_1()
    {
        $censored = Censor::censorOnStrategy('015226215421', Censor::STRATEGY_PHONE);
        $this->assertEquals('015226215***', $censored);
    }

    public function testPhone_2()
    {
        $censored = Censor::censorOnStrategy('+4915226215421', Censor::STRATEGY_PHONE);
        $this->assertEquals('+4915226215***', $censored);
    }

    public function testPhone_3()
    {
        $censored = Censor::censorOnStrategy('055343124', Censor::STRATEGY_PHONE);
        $this->assertEquals('055343***', $censored);
    }

    public function testPhoneShort_1()
    {
        $censored = Censor::censorOnStrategy('3124', Censor::STRATEGY_PHONE_SHORT);
        $this->assertEquals('31**', $censored);
    }

    public function testPhoneShort_2()
    {
        $censored = Censor::censorOnStrategy('588678', Censor::STRATEGY_PHONE_SHORT);
        $this->assertEquals('588***', $censored);
    }

    public function testPhoneShort_3()
    {
        $censored = Censor::censorOnStrategy('13345', Censor::STRATEGY_PHONE_SHORT);
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
}