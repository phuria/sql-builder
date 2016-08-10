# Phuria SQL Builder [![Build Status](https://travis-ci.org/phuria/sql-builder.svg?branch=master)](https://travis-ci.org/phuria/sql-builder)

### Requirements

PHP: `>=5.6.0`

### Examples

__Simple Query__

```php
$qb = new QueryBuilder();

$userTable = $qb->from('user');
$qb->addSelect($userTable->column('name'));
$userTable->setAlias('u');

$contactTable = $qb->leftJoin('contact');
$qb->addSelect($contactTable->column('phone_number');
$contactTable->setAlias('c');
$contactTable->joinOn(
    $userTable->column('id')->eq($contactTable->column('user_id'))
);

$sql = $qb->buildSQL();
```

```sql
SELECT u.name, c.phone_number FROM user AS u
LEFT JOIN contact AS c ON u.id = c.user_id;
```


__Custom table__

```php
use Phuria\QueryBuilder\Table\AbstractTable;

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

// By returned table
$accountTable = $qb->from('account');
$accountTable->onlyActive();

// By callback
$qb->from(function (AccountTable $table) {
    $table->onlyActive();
});

$qb->buildSQL();
```

```sql
SELECT * FROM account WHERE acount.active
```

### ASC / DESC Expression

```php
$qb = new QueryBuilder();

$ordersTable = $qb->from('orders');
$qb->addSelect('*');
$qb->addOrderBy($ordersTable->column('created_at')->desc());

$sql = $qb->buildSQL();
```

```sql
SELECT * FROM orders ORDER BY orders.created_at DESC
```

```php
$qb = new QueryBuilder();

$orderTable = $qb->from('orders');
$year = $orderTable->column('created_at')->year();
$qb->addSelect($orderTable->column('price')->sum());
$qb->addSelect($year);
$qb->addGroupBy($year->desc());

$sql = $qb->buildSQL();
```

```sql
SELECT SUM(orders.price), YEAR(orders.created_at) FROM orders
GROUP BY YEAR(ordsers.created_at) DESC
```

### Aggregate functions

```php
$qb = new QueryBuilder();

$priceListTable = $qb->from('pirce_list');
$qb->addSelect($qb->column('price')->sumNullable()->alias('price'));

$sql = $qb->getSQL();
```

```sql
SELECT SUM(IFNULL(price_list.price, 0)) AS price FROM price_list
```

### String functions

```php
$qb = new QueryBuilder();

$qb->addSelect(
    $qb->expr(10, 30, 40, $qb->expr('utf8')->using())->char()
);

$sql = $qb->buildSQL();
```

```sql
SELECT CHAR(10, 30, 40 USING utf8)
```