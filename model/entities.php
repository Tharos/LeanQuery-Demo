<?php

use LeanMapper\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string|null $web
 */
class Author extends Entity
{
}

/**
 * @property int $id
 * @property string $name
 */
class Tag extends Entity
{
}

/**
 * @property int $id
 *
 * @property Author $author m:hasOne
 * @property Author $reviewer m:hasOne(reviewer_id)
 * @property Tag[] $tags m:hasMany
 *
 * @property string $pubdate
 * @property string $name
 * @property string|null $description
 * @property string|null $website
 * @property bool $available = true
 */
class Book extends Entity
{
}

/**
 * @property int $id
 * @property string $name
 */
class Borrower extends Entity
{
}

/**
 * @property int $id
 * @property Book $book m:hasOne
 * @property Borrower $borrower m:hasOne
 * @property string $date
 */
class Borrowing extends Entity
{
}
