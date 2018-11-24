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
use RazeSoldier\JUnitLogParser\TestCaseBuilder;
use PHPUnit\Framework\TestCase;

class TestCaseBuilderTest extends TestCase
{
    public static function goodDataProvider()
    {
        return [
            'asset1' => [
                'name' => 'testCreate',
                'class' => 'CommandFactoryTest',
                'classname' => 'CommandFactoryTest',
                'file' => '/srv/devmw/w/tests/phpunit/includes/shell/CommandFactoryTest.php',
                'line' => 19,
                'assertions' => 5,
                'time' => 0.041866
            ],
        ];
    }

    /**
     * @covers \RazeSoldier\JUnitLogParser\TestCaseBuilder
     */
    public function testBuild()
    {
        $element = new Element('testcase', null, self::goodDataProvider()['asset1']);
        $builder = new TestCaseBuilder($element);
        $result = $builder->build();
        $this->assertSame(5, $result->getAssertionsCount());
        $this->assertSame('testCreate', $result->getName());
        $this->assertSame('/srv/devmw/w/tests/phpunit/includes/shell/CommandFactoryTest.php', $result->getFile());
        $this->assertSame(0.041866, $result->getTime());
        $this->assertSame('CommandFactoryTest', $result->getClass());
        $this->assertSame('CommandFactoryTest', $result->getClassname());
        $this->assertSame(19, $result->getLine());
        $this->assertSame(null, $result->getParent());
    }
}
