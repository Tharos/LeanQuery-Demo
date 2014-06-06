<?php

use LeanMapper\Connection;
use LeanMapper\DefaultEntityFactory;
use LeanQuery\DomainQueryFactory;
use LeanQuery\Hydrator;
use LeanQuery\QueryHelper;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/model/model.php';

// Init Lean Mapper

$connection = new Connection([
	'database' => __DIR__ . '/db.sq3',
	'driver' => 'sqlite3',
	'lazy' => true,
]);

$mapper = new Mapper;
$entityFactory = new DefaultEntityFactory;

// Init Lean Query

$queryHelper = new QueryHelper;
$hydrator = new Hydrator($connection, $mapper);
$domainQueryFactory = new DomainQueryFactory($entityFactory, $connection, $mapper, $hydrator, $queryHelper);

//////////

$queries = [];
$connection->onEvent[] = function ($event) use (&$queries) {
	$queries[] = $event->sql;
};

$borrowingRepository = new BorrowingRepository($connection, $mapper, $entityFactory, $domainQueryFactory);

$borrowingCriteria = (new BorrowingCriteria)
	->orderBy(BorrowingCriteria::ORDER_BOOK_AUTHOR_NAME)
	->preloadData(true);


foreach ($borrowingRepository->findAll($borrowingCriteria) as $borrowing) {
	echo implode('; ', [
		$borrowing->book->name . ' (' . $borrowing->book->author->name . ')',
		$borrowing->borrower->name,
		$borrowing->date,
	]) . "\n";
}

print_r($queries);
