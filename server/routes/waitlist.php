<?php
use Propel\Runtime\Propel;

$app->get('/waitlist', function () use ($app) {

    // authenticate before do anything
    if ( !authenticate($app->request->params('apiKey')) ) {
        $app->status(403);
        echo json_encode('You are not allowed to see this page.');
        return;
    }

    // check required params
    if(is_null($app->request->get('shift'))) {
        $app->status(406); 
        echo json_encode('You need to specify a shift.');
        return; 
    }
    
    // get request parameters
    $shiftId = $app->request->get('shift');

    // construct query
    $signups = WaitlistQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->addAsColumn('Id', 'members.id')
        ->select('Timestamp')
        ->orderByTimestamp('asc');

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Waitlists');
});

$app->get('/waitlist/user', function () use ($app) {

    // authenticate before do anything
    if ( !authenticate($app->request->params('apiKey')) ) {
        $app->status(403);
        echo json_encode('You are not allowed to see this page.');
        return;
    }

    // check required params
    if(is_null($app->request->get('id'))) {
        $app->status(406); 
        echo json_encode('You need to specify an id.');
        return; 
    }
    
    // get request parameters
    $userId = $app->request->get('id');
    $startTime = $app->request->get('startTime');

    // construct query
    $waitlists = WaitlistQuery::create()
        ->useEventsQuery()
            ->orderByDate('asc')
        ->endUse();

    $waitlists = $waitlists->useShiftsQuery();
    if(!is_null($startTime)) { $waitlists->where('shifts.start_time >= ?', $startTime); }
    $waitlists = $waitlists->endUse();
        
    $waitlists = $waitlists->filterByUser($userId)
        ->addAsColumn('StartTime', 'shifts.start_time')
        ->addAsColumn('EndTime', 'shifts.end_time')
        ->addAsColumn('Name', 'events.name')
        ->addAsColumn('Date', 'events.date')
        ->select(array('Event', 'User', 'Shift', 'Timestamp'))
        ->orderByTimestamp('asc');

    // execute and return
    returnDataJSON($waitlists->find()->toJSON(), 'Waitlists');
});

$app->post('/waitlist/add', function () use ($app) {

    // authenticate before do anything
    if ( !authenticate($app->request->params('apiKey')) ) {
        $app->status(403);
        echo json_encode('You are not allowed to see this page.');
        return;
    }

    // check required params
    if (is_null($app->request->post('user')) || 
        is_null($app->request->post('shift')) || 
        is_null($app->request->post('event')) || 
        is_null($app->request->post('timestamp'))) 
    {
        $app->status(406); 
        echo json_encode('You need to specify a user, shift, event and timestamp.');
        return; 
    }
    
    // get request parameters
    $userId = $app->request->post('user');
    $shiftId = $app->request->post('shift');
    $eventId = $app->request->post('event');
    $timestamp = $app->request->post('timestamp');

    // begin insertion
    $con = Propel::getConnection();
    $sql =  'INSERT INTO `waitlist` (`user`, `shift`, `event`, `timestamp`)'
            .' VALUES (' . $userId . ', ' . $shiftId . ', ' . $eventId . ', ' . $timestamp . ')';
    $stmt = $con->prepare($sql);
    $stmt->execute();

    // return updated waitlist
    $signups = WaitlistQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->addAsColumn('Id', 'members.id')
        ->select('Timestamp')
        ->orderByTimestamp('asc');

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Waitlists');
});

$app->post('/waitlist/delete', function () use ($app) {

    // authenticate before do anything
    if ( !authenticate($app->request->params('apiKey')) ) {
        $app->status(403);
        echo json_encode('You are not allowed to see this page.');
        return;
    }

    // check required params
    if (is_null($app->request->post('user')) || 
        is_null($app->request->post('shift')) || 
        is_null($app->request->post('event'))) 
    {
        $app->status(406); 
        echo json_encode('You need to specify a user, shift and event.');
        return; 
    }
    
    // get request parameters
    $userId = $app->request->post('user');
    $shiftId = $app->request->post('shift');
    $eventId = $app->request->post('event');

    // remove
    $signup = WaitlistQuery::create()
        ->filterByUser($userId)
        ->filterByShift($shiftId)
        ->filterByEvent($eventId)
        ->delete();

    // return updated waitlist
    $signups = WaitlistQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->addAsColumn('Id', 'members.id')
        ->select('Timestamp')
        ->orderByTimestamp('asc');

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Waitlists');
});