<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder;

use Phuria\UnderQuery\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UpdateBuilder extends AbstractBuilder implements
    Clause\JoinInterface,
    Clause\LimitInterface,
    Clause\OrderByInterface,
    Clause\SetInterface,
    Clause\WhereInterface
{
    use Clause\JoinTrait;
    use Clause\SetTrait;
    use Clause\WhereTrait;
    use Clause\OrderByTrait;
    use Clause\LimitTrait;

    /**
     * @var boolean
     */
    private $ignore = false;

    /**
     * @return boolean
     */
    public function isIgnore()
    {
        return $this->ignore;
    }

    /**
     * @param boolean $ignore
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    public function update($table, $alias = null)
    {
        return $this->addUpdate($table, $alias);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    public function addUpdate($table, $alias = null)
    {
        return $this->addRootTable($table, $alias);
    }
}