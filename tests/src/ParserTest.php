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

use RazeSoldier\JUnitLogParser\Parser;
use PHPUnit\Framework\TestCase;
use Wikimedia\AtEase\AtEase;

class ParserTest extends TestCase
{
    const ASSETS = [
        1 => ASSETS_DIR . '/1.xml',
        2 => ASSETS_DIR . '/2.xml',
        3 => ASSETS_DIR . '/3.xml',
        4 => ASSETS_DIR . '/4.xml',
    ];

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp "Failed\sto\sread.*"
     */
    public function testLoadFileException()
    {
        Parser::loadFile(rand(0, 100));
    }

    /**
     * @covers \RazeSoldier\JUnitLogParser\Parser::loadFile()
     */
    public function testLoadFile()
    {
        $this->assertInstanceOf(Parser::class, Parser::loadFile(self::ASSETS[1]));
    }

    /**
     * @covers \RazeSoldier\JUnitLogParser\Parser::load()
     * @covers \RazeSoldier\JUnitLogParser\Parser::__construct()
     */
    public function testLoad()
    {
        $this->assertInstanceOf(Parser::class, Parser::load(file_get_contents(self::ASSETS[1])));
    }

    /**
     * @covers \RazeSoldier\JUnitLogParser\Parser::getTestSuiteInfo()
     */
    public function testGetTestSuiteInfo()
    {
        $parser = Parser::loadFile(self::ASSETS[1]);
        $result = $parser->getTestSuiteInfo('ShellTest::testMakeScriptCommand');
        $expected = [
            'name' => 'ShellTest::testMakeScriptCommand',
            'file' => null,
            'time' => 0.002107,
            'tests' => 4,
            'skipped' => 0,
            'assertions' => 12,
            'errors' => 0,
            'failures' => 0,
        ];
        $this->assertSame($expected, $result);
    }

    public function testFindTestSuite()
    {
        $parser = Parser::loadFile(self::ASSETS[4]);
        $result = $parser->findTestSuite('FileBackendTest::testIsStoragePath');
        $this->assertSame(0.012495, $result->getTime());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage 'This is test' test suite does not exist
     */
    public function testFindTestSuiteException()
    {
        $parser = Parser::loadFile(self::ASSETS[1]);
        $parser->findTestSuite('This is test');
    }

    public function testGetTestResult()
    {
        $parser = Parser::loadFile(self::ASSETS[2]);
        $result = $parser->getTestResult();
        $expected = [
            'tests' => 10,
            'time' => 0.001265,
            'assertions' => 2,
            'errors' => 8,
            'failures' => 2,
            'skipped' => 0
        ];
        $this->assertSame($expected, [
            'tests' => $result->getTests(),
            'time' => $result->getTime(),
            'assertions' => $result->getAssertions(),
            'errors' => $result->getErrors(),
            'failures' => $result->getFailures(),
            'skipped' => $result->getSkipped()
        ]);

       $expexted = [
            'PHPUnit\Framework\ExpectationFailedException',
            "Wikimedia\IPSet\Test\IPSetTest::testMatchFailure with data set \"inet fail\" "
                . "('0af.0af', false)\nError: Class 'Wikimedia\IPSet' "
                . "not found\n\n/home/razesoldier/workspace/IPSet/tests/IPSetTest.php:352\n"
        ];
        $this->assertSame($expexted, [
            $result->getFaults()[6]['type'],
            $result->getFaults()[9]['text']
        ]);
    }

    /**
     * @expectedException \DOMException
     * @expectedExceptionMessage Cannot parse non-JUnit log format XML
     */
    public function testCheckValid()
    {
        AtEase::quietCall([Parser::class, 'loadFile'], self::ASSETS[3]);
    }

    public function testLoadBigLog()
    {
        $parser = Parser::loadFile(self::ASSETS[4]);
        $info = $parser->getTestSuiteInfo('ActorMigrationTest::testInsertRoundTrip');
        $this->assertSame(144, $info['assertions']);
    }
}
