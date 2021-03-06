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
    TestCase,
    ITestCase
};

class TestCaseBuilder extends AbstractMainComponentBuilder
{
    public function __construct(Element $element)
    {
        parent::__construct($element);
        $this->product = new TestCase();
    }

    public function build() : ITestCase
    {
        parent::build();
        $this->buildClass();
        $this->buildClassName();
        $this->buildLine();
        return $this->product;
    }

    private function buildClass()
    {
        $this->product->setClass($this->element->class);
    }

    private function buildClassName()
    {
        $this->product->setClassname($this->element->classname);
    }

    private function buildLine()
    {
        $this->product->setLine($this->element->line);
    }
}
