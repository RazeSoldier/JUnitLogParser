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

namespace RazeSoldier\JUnitLogParser\ComponentBuilder;

use DiDom\Element;
use RazeSoldier\JUnitLogParser\Component\{
    TestSuite,
    ITestSuite
};

class TestSuiteBuilder extends AbstractMainComponentBuilder
{
    public function __construct(Element $element)
    {
        parent::__construct($element);
        $this->product = new TestSuite();
    }

    public function build() : ITestSuite
    {
        parent::build();
        $this->buildTestsCount();
        $this->buildErrorsCount();
        $this->buildFailuresCount();
        $this->buildSkippedCount();
        return $this->product;
    }

    private function buildTestsCount()
    {
        $this->product->setTestsCount($this->element->tests);
    }

    private function buildErrorsCount()
    {
        $this->product->setErrorsCount($this->element->errors);
    }

    private function buildFailuresCount()
    {
        $this->product->setFailuresCount($this->element->failures);
    }

    private function buildSkippedCount()
    {
        $this->product->setSkippedCount($this->element->skipped);
    }
}
