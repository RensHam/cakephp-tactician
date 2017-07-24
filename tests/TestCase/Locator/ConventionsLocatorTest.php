<?php
/*
 * The MIT License
 *
 * Copyright 2017 Robert Pustułka <r.pustulka@robotusers.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Robotusers\Tactician\Test\TestCase\Locator;

use Cake\TestSuite\TestCase;
use Robotusers\Tactician\Locator\ConventionsLocator;

/**
 * Description of ConventionsLocatorTest
 *
 * @author Robert Pustułka <r.pustulka@robotusers.com>
 */
class ConventionsLocatorTest extends TestCase
{

    /**
     * @dataProvider commandNameProvider
     */
    public function testResolveHandlerName($commandName, $handlerName)
    {
        $locator = new ConventionsLocator();

        $name = $locator->resolveHandlerName($commandName);
        $this->assertEquals($handlerName, $name);
    }

    /**
     * @dataProvider commandHandlerProvider
     */
    public function testGetHandlerForCommand($commandName, $handlerName)
    {
        $locator = new ConventionsLocator();

        $name = $locator->getHandlerForCommand($commandName);
        $this->assertInstanceOf($handlerName, $name);
    }

    public function commandNameProvider()
    {
        return [
            ['App\\Command\\FooCommand', 'Foo'],
            ['App\\Command\\Foo', 'Foo'],
            ['My\\Plugin\\Command\\BarCommand', 'My/Plugin.Bar']
        ];
    }

    public function commandHandlerProvider()
    {
        return [
            ['App\\Command\\FooCommand', 'App\\Handler\\FooHandler'],
        ];
    }
}
