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

abstract class AbstractMainComponentBuilder implements IBuilder
{
    /**
     * @var Element
     */
    protected $element;

    /**
     * @var \RazeSoldier\JUnitLogParser\Component\IMainComponent
     */
    protected $product;

    /**
     * @var bool
     */
    protected $hasChildren;

    public function __construct(Element $element)
    {
        $this->element = $element;
        $this->hasChildren = $this->element->hasChildren();
    }

    public function build()
    {
        $this->buildName();
        $this->buildAssertionsCount();
        $this->buildTime();
        $this->buildFile();
        if ($this->hasChildren) {
            foreach ($this->element->children() as $child) {
                $builder = ComponentBuilderFactory::make($child);
                $this->product->addChildren($builder->build());
            }
        }
        return $this->product;
    }

    protected function buildName()
    {
        $this->product->setName($this->element->name);
    }

    protected function buildAssertionsCount()
    {
        $this->product->setAssertionsCount($this->element->assertions);
    }

    protected function buildTime()
    {
        $this->product->setTime($this->element->time);
    }

    protected function buildFile()
    {
        $this->product->setFile($this->element->file);
    }
}
