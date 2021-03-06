<?php
use Propel\Runtime\Propel;

$app->get('/shift', function () use ($app) {

    // authenticate before do anything
    if ( !authenticate($app->request->params('apiKey')) ) {
        $app->status(403);
        echo json_encode('You are not allowed to see this page.');
        return;
    }

    // check required params
    if(is_null($app->request->get('event'))) {
        $app->status(406); 
        echo json_encode('You need to specify an event.');
        return; 
    }
    
    // get request parameters
    $eventId = $app->request->get('event');
    $select = $app->request->get('select');

    // construct query
    $shifts = ShiftsQuery::create()
        ->filterByEvent($eventId);
    if(!is_null($select)) { $shifts = $shifts->select($select); }

    // execute query
    returnDataJSON($shifts->find()->toJSON(), 'Shiftss');

    // echo $shifts->toString();
});

$app->get('/shift/signups', function () use ($app) {

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
    $signups = SignupsQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->select(array('Driver', 'User'));

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Signupss');
});

$app->post('/shift/user/signups/add', function () use ($app) {

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
        is_null($app->request->post('driver')) || 
        is_null($app->request->post('timestamp'))) 
    {
        $app->status(406); 
        echo json_encode('You need to specify a user, shift, event, driver and timestamp.');
        return; 
    }
    
    // get request parameters
    $userId = $app->request->post('user');
    $shiftId = $app->request->post('shift');
    $eventId = $app->request->post('event');
    $driver = $app->request->post('driver');
    $timestamp = $app->request->post('timestamp');

    // check if cap is reached
    $cap = ShiftsQuery::create()
        ->findPk($shiftId)
        ->getCap();

    $signups = SignupsQuery::create()
        ->filterByShift($shiftId)
        ->count();

    if ($cap != 0 && $cap != -1 && !is_null($cap) && $signups >= $cap) {
        $app->status(500);
        echo json_encode('Cap has been reached.');
        return;

    // begin insertion
    } else {
        $con = Propel::getConnection();
        $sql =  'INSERT INTO `signups` (`user`, `shift`, `event`, `driver`, `timestamp`)'
                .' VALUES (' . $userId . ', ' . $shiftId . ', ' . $eventId . ', ' . $driver . ', ' . $timestamp . ')';
        $stmt = $con->prepare($sql);
        $stmt->execute();
    }

    // return updated signups
    $signups = SignupsQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->select(array('Driver', 'User'));

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Signupss');
});

$app->post('/shift/user/signups/change', function () use ($app) {

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
        is_null($app->request->post('driver'))) 
    {
        $app->status(406); 
        echo json_encode('You need to specify a user, shift, event and driver.');
        return; 
    }
    
    // get request parameters
    $userId = $app->request->post('user');
    $shiftId = $app->request->post('shift');
    $eventId = $app->request->post('event');
    $driver = $app->request->post('driver');

    // construct query
    $signup = SignupsQuery::create()
        ->filterByUser($userId)
        ->filterByShift($shiftId)
        ->filterByEvent($eventId)
        ->update(array('Driver' => $driver));

    // return updated signups
    $signups = SignupsQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->select(array('Driver', 'User'));

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Signupss');
});

$app->post('/shift/user/signups/delete', function () use ($app) {

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

    // remove from signups
    $signup = SignupsQuery::create()
        ->filterByUser($userId)
        ->filterByShift($shiftId)
        ->filterByEvent($eventId)
        ->delete();

    // get first on waitlist
    $waitlisted = WaitlistQuery::create()
        ->select(array('User', 'Shift', 'Event', 'Timestamp'))
        ->filterByShift($shiftId)
        ->orderByTimestamp('asc')
        ->limit(1);

    $waitlisted = json_decode($waitlisted->find()->toJSON())->Waitlists;

    // check if any waitlist
    $hasWaitlist = count($waitlisted);
    if($hasWaitlist == 1) {

        // insert into signups
        $con = Propel::getConnection();
        $sql =  'INSERT INTO `signups` (`user`, `shift`, `event`, `driver`, `timestamp`)'
                .' VALUES (' . $waitlisted[0]->User . ', ' . $waitlisted[0]->Shift . ', ' . $waitlisted[0]->Event . ', 0, ' . $waitlisted[0]->Timestamp . ')';
        $stmt = $con->prepare($sql);
        $stmt->execute();

        // remove from waitlist
        $waitlisted = WaitlistQuery::create()
            ->filterByUser($waitlisted[0]->User)
            ->filterByShift($waitlisted[0]->Shift)
            ->filterByEvent($waitlisted[0]->Event)
            ->delete();
    }

    // return updated signups
    $signups = SignupsQuery::create()
        ->useMembersQuery()
        ->endUse()
        ->filterByShift($shiftId)
        ->addAsColumn('FirstName', 'members.first_name')
        ->addAsColumn('LastName', 'members.last_name')
        ->select(array('Driver', 'User'));

    // execute and return
    returnDataJSON($signups->find()->toJSON(), 'Signupss');
});