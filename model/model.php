<?php

use LeanMapper\DefaultMapper;

require_once __DIR__ . '/entities.php';
require_once __DIR__ . '/repositories.php';


class Mapper extends DefaultMapper
{

	protected $defaultEntityNamespace = null;

}

class BorrowingCriteria
{

	const ORDER_BORROWING_DATE = 'borrowingDate';
	const ORDER_BORROWER_NAME = 'borrowerName';
	const ORDER_BOOK_NAME = 'bookName';
	const ORDER_BOOK_AUTHOR_NAME = 'bookAuthorName';

	/** @var string */
	private $orderBy = self::ORDER_BORROWING_DATE;

	/** @var bool */
	private $preloadData = false;


	/**
	 * @param string $property
	 * @return self
	 */
	public function orderBy($property)
	{
		$this->orderBy = $property;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrderBy()
	{
		return $this->orderBy;
	}

	/**
	 * @param bool $bool
	 * @return self
	 */
	public function preloadData($bool)
	{
		$this->preloadData = (bool) $bool;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function shouldPreloadData()
	{
		return $this->preloadData;
	}

}
