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

class TestResult
{
    private $tests;
    private $time;
    private $assertions;
    private $skipped;
    private $errors;
    private $failures;
    private $faults;

    public function __construct(array $data)
    {
        $this->tests = $data['tests'];
        $this->time = $data['time'];
        $this->assertions = $data['assertions'];
        $this->skipped = $data['skipped'];
        $this->errors = $data['errors'];
        $this->failures = $data['failures'];
        $this->faults = $data['faults'];
    }

    /**
     * @return int
     */
    public function getTests() : int
    {
        return $this->tests;
    }

    /**
     * @return float
     */
    public function getTime() : float
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getAssertions() : int
    {
        return $this->assertions;
    }

    /**
     * @return int
     */
    public function getSkipped() : int
    {
        return $this->skipped;
    }

    /**
     * @return int
     */
    public function getErrors() : int
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getFailures() : int
    {
        return $this->failures;
    }

    /**
     * @return array[]
     */
    public function getFaults() : array
    {
        return $this->faults;
    }

    /**
     * @return bool Returns TRUE on test passed, otherwise return FALSE
     */
    public function isPass() : bool
    {
        if ($this->failures === 0 && $this->errors === 0) {
            return true;
        }
        return false;
    }
}
