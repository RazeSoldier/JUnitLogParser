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

use RazeSoldier\JUnitLogParser\{
    Parser,
    Searcher\MainComponentSearcher
};
use RazeSoldier\JUnitLogParser\Component\{
    IMainComponent,
    ITestCase,
    ITestSuite
};
use PHPUnit\Framework\TestCase;

/**
 * @covers \RazeSoldier\JUnitLogParser\Searcher\MainComponentSearcher
 */
class NameSearcherTest extends TestCase
{
    /**
     * @var IMainComponent
     */
    private $set;

    public function setUp()
    {
        $parser = Parser::loadFile(ASSETS_DIR . '/1.xml');
        $this->set = $parser->getResult()[0];
    }

    public function testSearch()
    {
        $searcher = new MainComponentSearcher($this->set, 'CommandFactoryTest');
        $result = $searcher->search();
        $this->assertInstanceOf(ITestSuite::class, $result);
        $this->assertSame('/srv/devmw/w/tests/phpunit/includes/shell/CommandFactoryTest.php', $result->getFile());
        $this->assertSame(0.057585, $result->getTime());

        $searcher = new MainComponentSearcher($this->set, 'testInput');
        $result = $searcher->search();
        $this->assertInstanceOf(ITestCase::class, $result);
        $this->assertSame('/srv/devmw/w/tests/phpunit/includes/shell/CommandTest.php', $result->getFile());
        $this->assertSame(0.038575, $result->getTime());
    }

    public function testSearchWithHook()
    {
        $searcher = new MainComponentSearcher($this->set, 'testInput', function ($result) {
            return $result instanceof ITestCase ? false : true;
        });
        $result = $searcher->search();
        $this->assertFalse($result);
    }
}
