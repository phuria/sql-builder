# Phuria SQL Builder 
[![Build Status](https://img.shields.io/scrutinizer/build/g/phuria/sql-builder.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/phuria/sql-builder/build-status/master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/phuria/sql-builder.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/phuria/sql-builder.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/phuria/sql-builder/?branch=master)
[![GitHub release](https://img.shields.io/github/release/phuria/sql-builder.svg?maxAge=2592000?style=flat-square)]()
[![license](https://img.shields.io/github/license/phuria/sql-builder.svg?maxAge=2592000?style=flat-square)]()
[![php](https://img.shields.io/badge/PHP-5.6-blue.svg)]()

SQL query builder focused on:
 + object-oriented inheritance behavior in database's tables
 + possibility of doing everything that can be done in native syntax
 + being lightweight and fast (also in development)
 + easily to extend

```sh
php composer.phar require phuria/sql-builder
```


## Quick start

There are different query builders classes for each SQL query type: `SelectBuilder`, `UpdateBuilder`, `DeleteBuilder` and `InsertBuilder`.

Below are some simple examples of use.

#### Simple SELECT
```php
$qb = new SelectBuilder();

$qb->addSelect('u.name', 'c.phone_number');
$qb->from('user', 'u');
$qb->leftJoin('contact', 'c', 'u.id = c.user_id');

echo $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u LEFT JOIN contact AS c ON u.id = c.user_id;
```

#### Single Table DELETE
```php
$qb = new DeleteBuilder();

$qb->from('user');
$qb->andWhere('id = 1');

echo $qb->buildSQL();
```

```sql
DELETE FROM user WHERE id = 1;
```

#### Multiple Table DELETE
```php
$qb = new DeleteBuilder();

$qb->from('user', 'u');
$qb->innerJoin('contact', 'c', 'u.id = c.user_id')
$qb->addDelete('u', 'c');
$qb->andWhere('u.id = 1');

echo $qb->builidSQL();
```

```sql
DELETE u, c FROM user u LEFT JOIN contact c ON u.id = c.user_id WHERE u.id = 1 
```

#### Simple INSERT
```php
$qb = new InsertBuilder();

$qb->into('user', 'u', ['username', 'email']);
$qb->addValues(['phuria', 'spam@simko.it']);

echo $qb->buildSQL();
```

```sql
INSERT INTO user (username, email) VALUES ("phuria", "spam@simko.it")
```

#### INSERT ... SELECT
```php
$sourceQb = new SelectBuilder();

$sourceQb->from('transactions', 't');
$sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
$sourceQb->addGroupBy('t.user_id');

$targetQb = new InsertSelectBuilder();
$targetQb->into('user_summary', ['user_id', 'total_price']);
$targetQb->selectInsert($sourceQb);

echo $targetQb->buildSQL();
```

```sql
INSERT INTO user_summary (user_id, total_price) SELECT t.user_id, SUM(t.amount) FROM transactions AS t GROUP BY t.user_id
```

#### Simple UPDATE
```php
$qb = new UpdateBuilder();

$rootTable = $qb->update('user', 'u');
$qb->addSet("u.updated_at = NOW()");
$qb->andWhere("u.id = 1");
```

```sql
UPDATE user AS u SET u.updated_at = NOW() WHERE u.id = 1
```
## Create your own custom table

```php
use Phuria\SQLBuilder\Table\AbstractTable;

class AccountTable extends AbstractTable
{
    public function getTableName()
    {
        return 'account';
    }
    
    public function onlyActive()
    {
        $this->andWhere($this->column('active'));
    }
}
```

```php
$qb = new QueryBuilder();
$qb->addSelect('*');

$accountTable = $qb->from('account');
$accountTable->onlyActive();

$qb->buildSQL();
```

```sql
SELECT * FROM account WHERE acount.active
```

