<?php

namespace Map;

use \Events;
use \EventsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'events' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EventsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.EventsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'aphio';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'events';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Events';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Events';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 21;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 21;

    /**
     * the column name for the id field
     */
    const COL_ID = 'events.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'events.name';

    /**
     * the column name for the event_code field
     */
    const COL_EVENT_CODE = 'events.event_code';

    /**
     * the column name for the date field
     */
    const COL_DATE = 'events.date';

    /**
     * the column name for the location field
     */
    const COL_LOCATION = 'events.location';

    /**
     * the column name for the meet_location field
     */
    const COL_MEET_LOCATION = 'events.meet_location';

    /**
     * the column name for the meet_time field
     */
    const COL_MEET_TIME = 'events.meet_time';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'events.description';

    /**
     * the column name for the drivers_needed field
     */
    const COL_DRIVERS_NEEDED = 'events.drivers_needed';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'events.created_by';

    /**
     * the column name for the log_posted field
     */
    const COL_LOG_POSTED = 'events.log_posted';

    /**
     * the column name for the log_description field
     */
    const COL_LOG_DESCRIPTION = 'events.log_description';

    /**
     * the column name for the log_comments field
     */
    const COL_LOG_COMMENTS = 'events.log_comments';

    /**
     * the column name for the log_improvements field
     */
    const COL_LOG_IMPROVEMENTS = 'events.log_improvements';

    /**
     * the column name for the log_reattend field
     */
    const COL_LOG_REATTEND = 'events.log_reattend';

    /**
     * the column name for the organization field
     */
    const COL_ORGANIZATION = 'events.organization';

    /**
     * the column name for the contact_name field
     */
    const COL_CONTACT_NAME = 'events.contact_name';

    /**
     * the column name for the contact_phone field
     */
    const COL_CONTACT_PHONE = 'events.contact_phone';

    /**
     * the column name for the frat_expense field
     */
    const COL_FRAT_EXPENSE = 'events.frat_expense';

    /**
     * the column name for the loged_by field
     */
    const COL_LOGED_BY = 'events.loged_by';

    /**
     * the column name for the verified field
     */
    const COL_VERIFIED = 'events.verified';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'EventCode', 'Date', 'Location', 'MeetLocation', 'MeetTime', 'Description', 'DriversNeeded', 'CreatedBy', 'LogPosted', 'LogDescription', 'LogComments', 'LogImprovements', 'LogReattend', 'Organization', 'ContactName', 'ContactPhone', 'FratExpense', 'LogedBy', 'Verified', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'eventCode', 'date', 'location', 'meetLocation', 'meetTime', 'description', 'driversNeeded', 'createdBy', 'logPosted', 'logDescription', 'logComments', 'logImprovements', 'logReattend', 'organization', 'contactName', 'contactPhone', 'fratExpense', 'logedBy', 'verified', ),
        self::TYPE_COLNAME       => array(EventsTableMap::COL_ID, EventsTableMap::COL_NAME, EventsTableMap::COL_EVENT_CODE, EventsTableMap::COL_DATE, EventsTableMap::COL_LOCATION, EventsTableMap::COL_MEET_LOCATION, EventsTableMap::COL_MEET_TIME, EventsTableMap::COL_DESCRIPTION, EventsTableMap::COL_DRIVERS_NEEDED, EventsTableMap::COL_CREATED_BY, EventsTableMap::COL_LOG_POSTED, EventsTableMap::COL_LOG_DESCRIPTION, EventsTableMap::COL_LOG_COMMENTS, EventsTableMap::COL_LOG_IMPROVEMENTS, EventsTableMap::COL_LOG_REATTEND, EventsTableMap::COL_ORGANIZATION, EventsTableMap::COL_CONTACT_NAME, EventsTableMap::COL_CONTACT_PHONE, EventsTableMap::COL_FRAT_EXPENSE, EventsTableMap::COL_LOGED_BY, EventsTableMap::COL_VERIFIED, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'event_code', 'date', 'location', 'meet_location', 'meet_time', 'description', 'drivers_needed', 'created_by', 'log_posted', 'log_description', 'log_comments', 'log_improvements', 'log_reattend', 'organization', 'contact_name', 'contact_phone', 'frat_expense', 'loged_by', 'verified', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'EventCode' => 2, 'Date' => 3, 'Location' => 4, 'MeetLocation' => 5, 'MeetTime' => 6, 'Description' => 7, 'DriversNeeded' => 8, 'CreatedBy' => 9, 'LogPosted' => 10, 'LogDescription' => 11, 'LogComments' => 12, 'LogImprovements' => 13, 'LogReattend' => 14, 'Organization' => 15, 'ContactName' => 16, 'ContactPhone' => 17, 'FratExpense' => 18, 'LogedBy' => 19, 'Verified' => 20, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'eventCode' => 2, 'date' => 3, 'location' => 4, 'meetLocation' => 5, 'meetTime' => 6, 'description' => 7, 'driversNeeded' => 8, 'createdBy' => 9, 'logPosted' => 10, 'logDescription' => 11, 'logComments' => 12, 'logImprovements' => 13, 'logReattend' => 14, 'organization' => 15, 'contactName' => 16, 'contactPhone' => 17, 'fratExpense' => 18, 'logedBy' => 19, 'verified' => 20, ),
        self::TYPE_COLNAME       => array(EventsTableMap::COL_ID => 0, EventsTableMap::COL_NAME => 1, EventsTableMap::COL_EVENT_CODE => 2, EventsTableMap::COL_DATE => 3, EventsTableMap::COL_LOCATION => 4, EventsTableMap::COL_MEET_LOCATION => 5, EventsTableMap::COL_MEET_TIME => 6, EventsTableMap::COL_DESCRIPTION => 7, EventsTableMap::COL_DRIVERS_NEEDED => 8, EventsTableMap::COL_CREATED_BY => 9, EventsTableMap::COL_LOG_POSTED => 10, EventsTableMap::COL_LOG_DESCRIPTION => 11, EventsTableMap::COL_LOG_COMMENTS => 12, EventsTableMap::COL_LOG_IMPROVEMENTS => 13, EventsTableMap::COL_LOG_REATTEND => 14, EventsTableMap::COL_ORGANIZATION => 15, EventsTableMap::COL_CONTACT_NAME => 16, EventsTableMap::COL_CONTACT_PHONE => 17, EventsTableMap::COL_FRAT_EXPENSE => 18, EventsTableMap::COL_LOGED_BY => 19, EventsTableMap::COL_VERIFIED => 20, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'event_code' => 2, 'date' => 3, 'location' => 4, 'meet_location' => 5, 'meet_time' => 6, 'description' => 7, 'drivers_needed' => 8, 'created_by' => 9, 'log_posted' => 10, 'log_description' => 11, 'log_comments' => 12, 'log_improvements' => 13, 'log_reattend' => 14, 'organization' => 15, 'contact_name' => 16, 'contact_phone' => 17, 'frat_expense' => 18, 'loged_by' => 19, 'verified' => 20, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
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
        $this->setName('events');
        $this->setPhpName('Events');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Events');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 75, '');
        $this->addColumn('event_code', 'EventCode', 'INTEGER', true, 2, 0);
        $this->addColumn('date', 'Date', 'BIGINT', true, null, 0);
        $this->addColumn('location', 'Location', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meet_location', 'MeetLocation', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meet_time', 'MeetTime', 'LONGVARCHAR', false, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('drivers_needed', 'DriversNeeded', 'SMALLINT', true, 1, 0);
        $this->addColumn('created_by', 'CreatedBy', 'INTEGER', true, 10, 0);
        $this->addColumn('log_posted', 'LogPosted', 'BOOLEAN', true, 1, false);
        $this->addColumn('log_description', 'LogDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('log_comments', 'LogComments', 'LONGVARCHAR', false, null, null);
        $this->addColumn('log_improvements', 'LogImprovements', 'LONGVARCHAR', false, null, null);
        $this->addColumn('log_reattend', 'LogReattend', 'VARCHAR', false, 255, null);
        $this->addColumn('organization', 'Organization', 'LONGVARCHAR', false, null, null);
        $this->addColumn('contact_name', 'ContactName', 'LONGVARCHAR', false, null, null);
        $this->addColumn('contact_phone', 'ContactPhone', 'BIGINT', false, null, null);
        $this->addColumn('frat_expense', 'FratExpense', 'DOUBLE', false, null, null);
        $this->addColumn('loged_by', 'LogedBy', 'INTEGER', false, 10, null);
        $this->addColumn('verified', 'Verified', 'BOOLEAN', true, 1, false);
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
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? EventsTableMap::CLASS_DEFAULT : EventsTableMap::OM_CLASS;
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
     * @return array           (Events object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EventsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EventsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventsTableMap::OM_CLASS;
            /** @var Events $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventsTableMap::addInstanceToPool($obj, $key);
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
            $key = EventsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EventsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Events $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EventsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(EventsTableMap::COL_ID);
            $criteria->addSelectColumn(EventsTableMap::COL_NAME);
            $criteria->addSelectColumn(EventsTableMap::COL_EVENT_CODE);
            $criteria->addSelectColumn(EventsTableMap::COL_DATE);
            $criteria->addSelectColumn(EventsTableMap::COL_LOCATION);
            $criteria->addSelectColumn(EventsTableMap::COL_MEET_LOCATION);
            $criteria->addSelectColumn(EventsTableMap::COL_MEET_TIME);
            $criteria->addSelectColumn(EventsTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(EventsTableMap::COL_DRIVERS_NEEDED);
            $criteria->addSelectColumn(EventsTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(EventsTableMap::COL_LOG_POSTED);
            $criteria->addSelectColumn(EventsTableMap::COL_LOG_DESCRIPTION);
            $criteria->addSelectColumn(EventsTableMap::COL_LOG_COMMENTS);
            $criteria->addSelectColumn(EventsTableMap::COL_LOG_IMPROVEMENTS);
            $criteria->addSelectColumn(EventsTableMap::COL_LOG_REATTEND);
            $criteria->addSelectColumn(EventsTableMap::COL_ORGANIZATION);
            $criteria->addSelectColumn(EventsTableMap::COL_CONTACT_NAME);
            $criteria->addSelectColumn(EventsTableMap::COL_CONTACT_PHONE);
            $criteria->addSelectColumn(EventsTableMap::COL_FRAT_EXPENSE);
            $criteria->addSelectColumn(EventsTableMap::COL_LOGED_BY);
            $criteria->addSelectColumn(EventsTableMap::COL_VERIFIED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.event_code');
            $criteria->addSelectColumn($alias . '.date');
            $criteria->addSelectColumn($alias . '.location');
            $criteria->addSelectColumn($alias . '.meet_location');
            $criteria->addSelectColumn($alias . '.meet_time');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.drivers_needed');
            $criteria->addSelectColumn($alias . '.created_by');
            $criteria->addSelectColumn($alias . '.log_posted');
            $criteria->addSelectColumn($alias . '.log_description');
            $criteria->addSelectColumn($alias . '.log_comments');
            $criteria->addSelectColumn($alias . '.log_improvements');
            $criteria->addSelectColumn($alias . '.log_reattend');
            $criteria->addSelectColumn($alias . '.organization');
            $criteria->addSelectColumn($alias . '.contact_name');
            $criteria->addSelectColumn($alias . '.contact_phone');
            $criteria->addSelectColumn($alias . '.frat_expense');
            $criteria->addSelectColumn($alias . '.loged_by');
            $criteria->addSelectColumn($alias . '.verified');
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
        return Propel::getServiceContainer()->getDatabaseMap(EventsTableMap::DATABASE_NAME)->getTable(EventsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EventsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EventsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EventsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Events or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Events object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Events) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventsTableMap::DATABASE_NAME);
            $criteria->add(EventsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = EventsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EventsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the events table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EventsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Events or Criteria object.
     *
     * @param mixed               $criteria Criteria or Events object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Events object
        }

        if ($criteria->containsKey(EventsTableMap::COL_ID) && $criteria->keyContainsValue(EventsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EventsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = EventsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EventsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EventsTableMap::buildTableMap();
