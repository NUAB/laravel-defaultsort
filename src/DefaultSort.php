<?php
namespace HeppyKarlsson\DefaultSort;

/**
 * The DefaultSort trait is to set a default sort order for a model.
 * <br><br>
 * To use the trait you have to specify which column(s) to sort on:
 *<br>
 * <code>
 * public $defaultSort = 'COLUMN1';
 * </code>
 *<br>
 * Or you can specify multiple columns:
 * <code>
 *     public $defaultSort = [
 *      'COLUMN1',
 *      'COLUMN2'
 * ];
 * </code>
 *<br>
 * You can specify the desired sortmethod:
 * <code>
 *     public $defaultSort = [
 *      'COLUMN1' => 'DESC',
 *      'COLUMN2' => 'ASC'
 * ];
 * </code>
 *
 * @package HeppyKarlsson\DefaultSort
 */
trait DefaultSort
{
    public static function bootDefaultSort() {
        static::addGlobalScope(new DefaultSortScope);
    }
}