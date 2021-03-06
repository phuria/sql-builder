<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\TestCase;

use Phuria\UnderQuery\UnderQuery;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait UnderQueryTrait
{
    /**
     * @return UnderQuery
     */
    protected static function underQuery()
    {
        return new UnderQuery();
    }
}