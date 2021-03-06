<?php

namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasic\CodeStyle;

use Paysera\PhpCsFixerConfig\Fixer\PhpBasic\CodeStyle\NamespacesAndUseStatementsFixer;
use PhpCsFixer\Test\AbstractFixerTestCase;

final class NamespacesAndUseStatementsFixerTest extends AbstractFixerTestCase
{
    /**
     * @param string $expected
     * @param null|string $input
     *
     * @dataProvider provideCases
     */
    public function testFix($expected, $input = null)
    {
        $this->doTest($expected, $input);
    }

    public function provideCases()
    {
        return [
            [
                '<?php
namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasics;
use Wallet\AccountInfo;
class Sample
{
    /**
     * @var AccountInfo not persisted to database
     */
    protected $accountInfo;
    
    /**
     * Gets accountInfo
     *
     * @param \WebToPay\ApiBundle\Entity\Wallet\AccountInfo $accountInfo
     *
     * @return $this
     */
    public function setAccountInfo($accountInfo)
    {
        $this->accountInfo = $accountInfo;

        return $this;
    }
}',
                '<?php
namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasics;
class Sample
{
    /**
     * @var Wallet\AccountInfo not persisted to database
     */
    protected $accountInfo;
    
    /**
     * Gets accountInfo
     *
     * @param \WebToPay\ApiBundle\Entity\Wallet\AccountInfo $accountInfo
     *
     * @return $this
     */
    public function setAccountInfo($accountInfo)
    {
        $this->accountInfo = $accountInfo;

        return $this;
    }
}'
            ],
            [
                '<?php
namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasics;
use Some\Another\Custom\Exception\SomeException;
use Some\Custom\Exception\InvalidArgumentException;
class Sample
{
    /**
     * @throws \Evp\Component\TextFilter\Exception
     * @throws \Exception
     * @throws InvalidArgumentException
     * @throws SomeException
     */
    public function sampleFunction()
    {
        if (true) {
            throw new \Evp\Component\TextFilter\Exception();
        } else {
            throw new \Exception("Some exception");
        }
        throw new InvalidArgumentException("Some exception");
    }
}',
                '<?php
namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasics;
class Sample
{
    /**
     * @throws \Evp\Component\TextFilter\Exception
     * @throws \Exception
     * @throws \Some\Custom\Exception\InvalidArgumentException
     * @throws \Some\Another\Custom\Exception\SomeException
     */
    public function sampleFunction()
    {
        if (true) {
            throw new \Evp\Component\TextFilter\Exception();
        } else {
            throw new \Exception("Some exception");
        }
        throw new \Some\Custom\Exception\InvalidArgumentException("Some exception");
    }
}'
            ],
            [
                '<?php
namespace Paysera\RestrictionBundle\Exception;

class RestrictionException extends \Exception
{
}'
            ],
            [
                '<?php
namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasic;
use Paysera\PhpCsFixerConfig\Fixer\PhpBasic\NamespacesAndUseStatementsFixer;
use Evp\Component\TextFilter\TextFilter;

class Sample
{
    /**
     * @var TextFilter
     */
    protected $textFilter;

    public function sampleFunction(NamespacesAndUseStatementsFixer $fixer)
    {
        $someConstant = Some\Custom\Ns\MyClass::CONSTANT;
        $value = new NamespacesAndUseStatementsFixer();
        $someConstantValue = NamespacesAndUseStatementsFixer::CONSTANT_VALUE;
        if ($someConstant instanceof NamespacesAndUseStatementsFixer) {
            return 0;
        }
    }
}', '<?php
namespace Paysera\PhpCsFixerConfig\Tests\Fixer\PhpBasic;

class Sample
{
    /**
     * @var \Evp\Component\TextFilter\TextFilter
     */
    protected $textFilter;

    public function sampleFunction(\Paysera\PhpCsFixerConfig\Fixer\PhpBasic\NamespacesAndUseStatementsFixer $fixer)
    {
        $someConstant = Some\Custom\Ns\MyClass::CONSTANT;
        $value = new \Paysera\PhpCsFixerConfig\Fixer\PhpBasic\NamespacesAndUseStatementsFixer();
        $someConstantValue = \Paysera\PhpCsFixerConfig\Fixer\PhpBasic\NamespacesAndUseStatementsFixer::CONSTANT_VALUE;
        if ($someConstant instanceof \Paysera\PhpCsFixerConfig\Fixer\PhpBasic\NamespacesAndUseStatementsFixer) {
            return 0;
        }
    }
}',
            ],
        ];
    }

    public function createFixerFactory()
    {
        $fixerFactory = parent::createFixerFactory();
        $fixerFactory->registerCustomFixers([
            new NamespacesAndUseStatementsFixer(),
        ]);
        return $fixerFactory;
    }

    public function getFixerName()
    {
        return 'Paysera/php_basic_code_style_namespaces_and_use_statements';
    }
}
