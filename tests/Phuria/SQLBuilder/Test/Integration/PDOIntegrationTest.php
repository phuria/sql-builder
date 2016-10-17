<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Integration;

use Phuria\SQLBuilder\Parameter\ParameterManager;
use Phuria\SQLBuilder\Query\Query;
use Phuria\SQLBuilder\Test\TestCase\DatabaseTestCase;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOIntegrationTest extends DatabaseTestCase
{
    /**
     * @test
     * @coversNothing
     */
    public function itShouldBuildValidStatement()
    {
        $connection = $this->createQueryConnection();
        $sql = 'SELECT * FROM user WHERE id=1';
        $query = new Query($sql, new ParameterManager(), $connection);

        static::assertSame(1, $query->rowCount());
    }

}