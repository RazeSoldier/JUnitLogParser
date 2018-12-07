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

class ComponentBuilderFactory
{
    public static function make(Element $element) : IBuilder
    {
        switch ($element->tag) {
            case 'testsuite':
                return new TestSuiteBuilder($element);
            case 'testcase':
                return new TestCaseBuilder($element);
            case 'failure':
                return new TestFailureBuilder($element);
            case 'error':
                return new TestErrorBuilder($element);
            case 'skipped':
                return new TestSkippedBuilder;
            case 'warning':
                return new TestWarningBuilder($element);
            case 'system-err':
                return new TestSystemErrorBuilder;
            case 'system-out':
                return new TestSystemOutBuilder;
            default:
                throw new \LogicException("Failed to parse '{$element->tag}'");
        }
    }
}
