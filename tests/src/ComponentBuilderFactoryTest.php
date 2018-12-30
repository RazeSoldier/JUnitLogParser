<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @copyright
 */

namespace RazeSoldier\JUnitLogParser\Test;

use DiDom\Element;
use RazeSoldier\JUnitLogParser\ComponentBuilder\ComponentBuilderFactory;
use PHPUnit\Framework\TestCase;

class ComponentBuilderFactoryTest extends TestCase
{
    public static function dataProvider()
    {
        return [
            'name' => 'testCreate',
            'class' => 'CommandFactoryTest',
            'classname' => 'CommandFactoryTest',
            'file' => '/srv/devmw/w/tests/phpunit/includes/shell/CommandFactoryTest.php',
            'line' => 19,
            'assertions' => 5,
            'time' => 0.041866
        ];
    }

    /**
     * @covers \RazeSoldier\JUnitLogParser\ComponentBuilder\ComponentBuilderFactory::make()
     * @expectedException \LogicException
     * @expectedExceptionMessage Failed to parse 'foo'
     */
    public function testMakeThrowException()
    {
        $element = new Element('foo', null, self::dataProvider());
        ComponentBuilderFactory::make($element);
    }
}
