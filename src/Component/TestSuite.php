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

namespace RazeSoldier\JUnitLogParser\Component;

class TestSuite extends AbstractMainComponent implements ITestSuite
{
    /**
     * @var int The count of tests for this suite
     */
    private $testsCount;

    /**
     * @var int The count of error tests for this suite
     */
    private $errorsCount;

    /**
     * @var int|null The count of failure tests for this suite
     */
    private $failuresCount;

    /**
     * @var int|null The count of skipped tests for this suite
     */
    private $skippedCount;

    public function __construct(IComponent $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @var IComponent[] Get all the children under the current component
     * @return array
     */
    public function getChildren() : array
    {
        return $this->children;
    }

    public function getTestsCount() : int
    {
        return $this->testsCount;
    }

    public function getErrorsCount() : int
    {
        return $this->errorsCount;
    }

    public function getFailuresCount() : int
    {
        return $this->failuresCount;
    }

    public function getSkippedCount() : int
    {
        return $this->skippedCount;
    }

    /**
     * @param int $testsCount
     */
    public function setTestsCount(?int $testsCount)
    {
        $this->testsCount = $testsCount ?? 0;
    }

    public function setErrorsCount(?int $count)
    {
        $this->errorsCount = $count ?? 0;
    }

    public function setFailuresCount(?int $count)
    {
        $this->failuresCount = $count ?? 0;
    }

    public function setSkippedCount(?int $count)
    {
        $this->skippedCount = $count ?? 0;
    }
}
