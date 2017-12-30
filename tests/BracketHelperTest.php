<?php

/*
 * This file is part of the bracket-helper project for otus.ru studies.
 *
 * (c) Deniss Kozickis <deniss.kozickis@gmail.com>
 *
 * Use and reuse as much as you want.
 * Distributed under Apache License 2.0
 */

namespace Dkozickis\Tests;

use Dkozickis\BracketHelper;

class BracketHelperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BracketHelper
     */
    private $bracketHelper;

    public function setUp()
    {
        $this->bracketHelper = new BracketHelper();
    }

    /**
     * @dataProvider stringWithBoolReturn
     *
     * @param $string
     * @param $returnValue
     */
    public function testIsValid($string, $returnValue)
    {
        $check = $this->bracketHelper->isValid($string);
        $this->assertSame($returnValue, $check);
    }

    /**
     * @dataProvider stringsWithException
     *
     * @param $string
     */
    public function testIsException($string)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->bracketHelper->isValid($string);
    }

    /**
     * @return array
     */
    public function stringWithBoolReturn()
    {
        return [
            ['(())', true],
            ['', true],
            ['((
            ))', true],
            ['((', false],
            ['(((()))))', false],
            ['(()()()()))((((()()()))(()()()(((()))))))', false],
            ['((()))((()))((())())', true],
        ];
    }

    /**
     * @return array
     */
    public function stringsWithException()
    {
        return [
            ['aaa'],
            ['((aaa))'],
            ['(())(())(())(())(((())))aa'],
        ];
    }
}
