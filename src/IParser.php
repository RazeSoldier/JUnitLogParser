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

namespace RazeSoldier\JUnitLogParser;

use RazeSoldier\JUnitLogParser\Component\ITestSuite;

interface IParser
{
    /**
     * IParser constructor.
     * @param string $str Text that JUnit log format
     * @param bool $graceful throws an exception if schema is not valid when false
     */
    public function __construct(string $str, bool $graceful = false);

    /**
     * Initialize the parser from an xml file
     * @param string $path
     * @return IParser
     */
    public static function loadFile(string $path) : IParser;

    /**
     * Initialize the parser from an xml text
     * @param string $xml
     * @return IParser
     */
    public static function load(string $xml) : IParser;

    /**
     * @return array Returns parse result, without any handle
     */
    public function getRawResult() : array;

    /**
     * @param string $testSuiteName
     * @return array
     *  - name
     *  - file
     *  - time
     *  - tests
     *  - skipped
     *  - assertions
     *  - errors
     *  - failures
     */
    public function getTestSuiteInfo(string $testSuiteName) : array;

    /**
     * Find a test suite from the parser result
     * @param string $name
     * @return ITestSuite
     */
    public function findTestSuite(string $name) : ITestSuite;

    /**
     * Get the test result from given log
     * @return TestResult
     */
    public function getTestResult() : TestResult;

    /**
     * Check if the test passed
     * @return bool Returns TRUE on passed, otherwise return FALSE
     */
    public function isPass() : bool;
}
