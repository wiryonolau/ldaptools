<?php

/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LdapTools\Query\Operator;

/**
 * Common methods and properties needed to represent an Operator that can contain other Operators.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
trait ContainsOperatorsTrait
{
    /**
     * The operators within this operator.
     *
     * @var BaseOperator[]
     */
    protected $children = [];

    /**
     * Get all the children operators within an operator.
     *
     * @return BaseOperator[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add operator(s) to an operator.
     *
     * @param BaseOperator[]|BaseOperator ...$operators
     */
    public function add(BaseOperator ...$operators)
    {
        $this->children = array_merge($this->children, $operators);
    }

    /**
     * @inheritdoc
     */
    public function toLdapFilter($alias = null)
    {
        $innerFilter = $this->getChildrenFilterString($alias);
        if (empty($innerFilter)) {
            return '';
        }

        return BaseOperator::SEPARATOR_START . bAnd::SYMBOL . $innerFilter . BaseOperator::SEPARATOR_END;
    }

    /**
     * @param string|null $alias
     * @return string
     */
    protected function getChildrenFilterString($alias = null)
    {
        $filters = [];
        foreach ($this->children as $child) {
            $filters[] = $child->toLdapFilter($alias);
        }

        return implode($filters);
    }
}
