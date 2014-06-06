<?php

use LeanMapper\Connection;
use LeanMapper\IEntityFactory;
use LeanMapper\IMapper;
use LeanMapper\Repository;
use LeanQuery\DomainQueryFactory;

class BorrowingRepository extends Repository
{

	/** @var DomainQueryFactory */
	private $domainQueryFactory;


	/**
	 * @param Connection $connection
	 * @param IMapper $mapper
	 * @param IEntityFactory $entityFactory
	 * @param DomainQueryFactory $domainQueryFactory
	 */
	public function __construct(Connection $connection, IMapper $mapper, IEntityFactory $entityFactory, DomainQueryFactory $domainQueryFactory)
	{
		parent::__construct($connection, $mapper, $entityFactory);
		$this->domainQueryFactory = $domainQueryFactory;
	}

	/**
	 * @param BorrowingCriteria $criteria
	 * @return Borrowing[]
	 */
	public function findAll(BorrowingCriteria $criteria)
	{
		$query = $this->domainQueryFactory->createQuery()
			->select('borrowing')
			->from(Borrowing::class, 'borrowing');

		$orderBy = $criteria->getOrderBy();

		if ($orderBy === BorrowingCriteria::ORDER_BOOK_NAME) {
			$query->join('borrowing.book', 'book')
				->orderBy('book.name');

			if ($criteria->shouldPreloadData()) {
				$query->select('book');
			}

		} elseif ($orderBy === BorrowingCriteria::ORDER_BORROWING_DATE) {
			$query->orderBy('borrowing.date');

		} elseif ($orderBy === BorrowingCriteria::ORDER_BORROWER_NAME) {
			$query->join('borrowing.borrower', 'borrower')
				->orderBy('borrower.name');

			if ($criteria->shouldPreloadData()) {
				$query->select('borrower');
			}

		} elseif ($orderBy === BorrowingCriteria::ORDER_BOOK_AUTHOR_NAME) {
			$query->join('borrowing.book', 'book')
				->join('book.author', 'a')
				->orderBy('a.name');

			if ($criteria->shouldPreloadData()) {
				$query->select('book, a');
			}
		}

		return $query->getEntities();
	}

}
