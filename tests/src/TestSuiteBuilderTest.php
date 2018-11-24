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
use RazeSoldier\JUnitLogParser\TestSuiteBuilder;
use PHPUnit\Framework\TestCase;

class TestSuiteBuilderTest extends TestCase
{
    public static function goodDataProvider()
    {
        return [
            'asset1' => [
                'name' => 'CommandFactoryTest',
                'file' => '/srv/devmw/w/tests/phpunit/includes/shell/CommandFactoryTest.php',
                'assertions' => 7,
                'tests' => 3,
                'errors' => 0,
                'failures' => 0,
                'skipped' => 0,
                'time' => 0.057585
            ],
        ];
    }

    /**
     * @covers \RazeSoldier\JUnitLogParser\TestSuiteBuilder
     */
    public function testBuild()
    {
        $element = new Element('testsuite', null, self::goodDataProvider()['asset1']);
        $builder = new TestSuiteBuilder($element);
        $result = $builder->build();
        $this->assertSame(7, $result->getAssertionsCount());
        $this->assertSame('CommandFactoryTest', $result->getName());
        $this->assertSame('/srv/devmw/w/tests/phpunit/includes/shell/CommandFactoryTest.php', $result->getFile());
        $this->assertSame(0.057585, $result->getTime());
        $this->assertSame(0, $result->getErrorsCount());
        $this->assertSame(0, $result->getFailuresCount());
        $this->assertSame(0, $result->getSkippedCount());
        $this->assertSame(3, $result->getTestsCount());
        $this->assertSame(null, $result->getParent());
    }
}
