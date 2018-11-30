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

class ParserTest extends TestCase
{
    const ASSETS = [
        1 => ASSETS_DIR . '/1.xml'
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

    public function testGetTestResult()
    {
        $parser = Parser::loadFile(self::ASSETS[1]);
        $result = $parser->getTestResult();
        $expected = [
            'tests' => 33,
            'time' => 0.403546,
            'assertions' => 69,
            'errors' => 0,
            'failures' => 0,
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
    }
}