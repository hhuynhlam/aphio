<?php

namespace Map;

use \Bbcode;
use \BbcodeQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'bbcode' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BbcodeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.BbcodeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aphio';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'bbcode';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Bbcode';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Bbcode';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the name field
     */
    const COL_NAME = 'bbcode.name';

    /**
     * the column name for the bbcode_expr field
     */
    const COL_BBCODE_EXPR = 'bbcode.bbcode_expr';

    /**
     * the column name for the html_rep field
     */
    const COL_HTML_REP = 'bbcode.html_rep';

    /**
     * the column name for the html_expr field
     */
    const COL_HTML_EXPR = 'bbcode.html_expr';

    /**
     * the column name for the bbcode_rep field
     */
    const COL_BBCODE_REP = 'bbcode.bbcode_rep';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Name', 'BbcodeExpr', 'HtmlRep', 'HtmlExpr', 'BbcodeRep', ),
        self::TYPE_CAMELNAME     => array('name', 'bbcodeExpr', 'htmlRep', 'htmlExpr', 'bbcodeRep', ),
        self::TYPE_COLNAME       => array(BbcodeTableMap::COL_NAME, BbcodeTableMap::COL_BBCODE_EXPR, BbcodeTableMap::COL_HTML_REP, BbcodeTableMap::COL_HTML_EXPR, BbcodeTableMap::COL_BBCODE_REP, ),
        self::TYPE_FIELDNAME     => array('name', 'bbcode_expr', 'html_rep', 'html_expr', 'bbcode_rep', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Name' => 0, 'BbcodeExpr' => 1, 'HtmlRep' => 2, 'HtmlExpr' => 3, 'BbcodeRep' => 4, ),
        self::TYPE_CAMELNAME     => array('name' => 0, 'bbcodeExpr' => 1, 'htmlRep' => 2, 'htmlExpr' => 3, 'bbcodeRep' => 4, ),
        self::TYPE_COLNAME       => array(BbcodeTableMap::COL_NAME => 0, BbcodeTableMap::COL_BBCODE_EXPR => 1, BbcodeTableMap::COL_HTML_REP => 2, BbcodeTableMap::COL_HTML_EXPR => 3, BbcodeTableMap::COL_BBCODE_REP => 4, ),
        self::TYPE_FIELDNAME     => array('name' => 0, 'bbcode_expr' => 1, 'html_rep' => 2, 'html_expr' => 3, 'bbcode_rep' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('bbcode');
        $this->setPhpName('Bbcode');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Bbcode');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('name', 'Name', 'VARCHAR', true, 15, '');
        $this->addColumn('bbcode_expr', 'BbcodeExpr', 'VARCHAR', true, 200, '');
        $this->addColumn('html_rep', 'HtmlRep', 'VARCHAR', true, 200, '');
        $this->addColumn('html_expr', 'HtmlExpr', 'VARCHAR', true, 200, '');
        $this->addColumn('bbcode_rep', 'BbcodeRep', 'VARCHAR', true, 200, '');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return null;
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return '';
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? BbcodeTableMap::CLASS_DEFAULT : BbcodeTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Bbcode object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BbcodeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BbcodeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BbcodeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BbcodeTableMap::OM_CLASS;
            /** @var Bbcode $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BbcodeTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = BbcodeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BbcodeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Bbcode $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BbcodeTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(BbcodeTableMap::COL_NAME);
            $criteria->addSelectColumn(BbcodeTableMap::COL_BBCODE_EXPR);
            $criteria->addSelectColumn(BbcodeTableMap::COL_HTML_REP);
            $criteria->addSelectColumn(BbcodeTableMap::COL_HTML_EXPR);
            $criteria->addSelectColumn(BbcodeTableMap::COL_BBCODE_REP);
        } else {
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.bbcode_expr');
            $criteria->addSelectColumn($alias . '.html_rep');
            $criteria->addSelectColumn($alias . '.html_expr');
            $criteria->addSelectColumn($alias . '.bbcode_rep');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(BbcodeTableMap::DATABASE_NAME)->getTable(BbcodeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BbcodeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BbcodeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BbcodeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Bbcode or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Bbcode object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BbcodeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Bbcode) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The Bbcode object has no primary key');
        }

        $query = BbcodeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BbcodeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BbcodeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the bbcode table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BbcodeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Bbcode or Criteria object.
     *
     * @param mixed               $criteria Criteria or Bbcode object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BbcodeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Bbcode object
        }


        // Set the correct dbName
        $query = BbcodeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BbcodeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BbcodeTableMap::buildTableMap();
