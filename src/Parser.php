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

use DiDom\Document;
use RazeSoldier\JUnitLogParser\ComponentBuilder\ComponentBuilderFactory;
use RazeSoldier\JUnitLogParser\Component\{
    ITestCase,
    ITestSuite
};

class Parser implements IParser
{
    const XSD_PATH = __DIR__ . '/junit.xsd';

    /**
     * @var Document
     */
    private $doc;

    /**
     * @var Component\ITestSuite[]
     */
    private $result = [];

    public function __construct(string $str)
    {
        $doc = new Document();
        $doc->loadXML($str);
        if (!$this->checkValid($doc->getDocument())) {
            throw new \DOMException('Cannot parse non-JUnit log format XML');
        }
        $this->doc = $doc;
        $this->parse();
    }

    private function checkValid(\DOMDocument $doc) : bool
    {
        return $doc->schemaValidate(self::XSD_PATH);
    }

    /**
     * @param string $path
     * @return Parser
     */
    public static function loadFile(string $path) : IParser
    {
        if (!is_readable($path)) {
            throw new \RuntimeException("Failed to read '$path'");
        }
        $path = realpath($path);
        return new self(file_get_contents($path));
    }

    public static function load(string $xml) : IParser
    {
        return new self($xml);
    }

    public function getResult() : array
    {
        return $this->result;
    }

    private function parse()
    {
        /** @var \DiDom\Element[] $testsuites */
        $testsuites = $this->doc->find('testsuites')[0]->children();
        foreach ($testsuites as $testsuite) {
            $builder = ComponentBuilderFactory::make($testsuite);
            $this->result[] = $builder->build();
        }
    }

    /**
     * @param string $testSuiteName
     * @throws \RuntimeException
     * @return array
     */
    public function getTestSuiteInfo(string $testSuiteName) : array
    {
        foreach ($this->result as $item) {
            $result = (new NameSearcher($item, $testSuiteName, function ($result) {
                return $result instanceof ITestCase ? false : true;
            }))->search();
            if ($result !== false) {
                break;
            }
        }
        /** @var ITestSuite|false $result */
        if ($result === false) {
            throw new \RuntimeException("'$testSuiteName' test suite does not exist");
        }
        return [
            'name' => $result->getName(),
            'file' => $result->getFile(),
            'time' => $result->getTime(),
            'tests' => $result->getTestsCount(),
            'skipped' => $result->getSkippedCount(),
            'assertions' => $result->getAssertionsCount(),
            'errors' => $result->getErrorsCount(),
            'failures' => $result->getFailuresCount(),
        ];
    }

    public function getTestResult() : TestResult
    {
        $tests = 0;
        $time = 0;
        $skipped = 0;
        $assertions = 0;
        $errors = 0;
        $failures = 0;
        $faults = [];
        foreach ($this->result as $item) {
            $tests += $item->getTestsCount();
            $assertions += $item->getAssertionsCount();
            $skipped += $item->getSkippedCount();
            $errors += $item->getErrorsCount();
            $failures += $item->getFailuresCount();
            $time += $item->getTime();
            if ($item->getErrorsCount() || $item->getFailuresCount()) {
                $fault = (new FaultSearcher($item))->search();
                $faults = array_merge($faults, $fault);
            }
        }
        $result = new TestResult(compact('tests', 'assertions', 'skipped', 'errors', 'failures', 'time', 'faults'));
        return $result;
    }
}
