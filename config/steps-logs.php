<?php

return [

    'ProgressLogs' => [

        'create' => 'New Comment Created [%INFO%]: %NOTE% -- [%EXTRAINFO%]',
        'remoteResponse' => 'Remote Response at %RESPONSE% by %BY%',
        'fixedAt' => 'Fixed at %FIX% by %BY%',
        'breach' => 'The service level agreement has been breached at %BREACH%',
        'working' => '%USER% is currently working on the '.env('TICKET_MONIKER'),
        'unsetWorking' => '%USER% has removed the working flag',
        'assignedTo' => '%USER% assigned the '.env('TICKET_MONIKER').' to %ASSIGNEE% -- %DATETIME%',
        'unassigned' => '%USER% unassigned %ASSIGNEE% -- %DATETIME%',
        'email' => 'Progress Log %LOGNUMBER% has been emailed to %RECEIVER%',
        'complete' => env('TICKET_MONIKER').' closed by %USER%',
        'resolve' => '%USER% has resolved the case at %DATETIME%',

    ],
    'siteVisit' => [
        'visitCreated' => 'Site Visit scheduled for %ASSIGNEE% by %SCHEDULER% on %DATETIME%',
        'VisitNote' => 'Site Visit Note : %NOTE% -- [%CREATEDBY%]',
        'scheduledUpdated' => 'Scheduled Date %SCHEDULED% has been changed to %DATETIME% -- [%USER%]',
        'enrouteUpdated' => '%ASSIGNEE% enroute to site at %DATETIME% -- [%USER%]',
        'enrouteRemoved' => 'Enroute has been removed -- [%USER%]',
        'onsiteUpdate' => '%ASSIGNEE% is on site at %DATETIME% -- [%USER%]',
        'onsiteRemoved' => 'Onsite has been removed -- [%USER%]',
        'offsiteUpdate' => '%ASSIGNEE% is off site at %DATETIME% -- [%USER%]',
        'offsiteRemoved' => 'Off site has been removed -- [%USER%]',
        'assignedToUpdated' => 'Visit assignee has been changed from %CURRENT% to %NEW% -- [%USER%]',
        'delete' => 'Site visit with a short description "%DESCRIPTION%" has been removed %DATETIME%-- [%USER%]',
    ],
    'ticket' => [
        'create' => env('TICKET_MONIKER').' created at %CREATED% by %BY%',
    ],
    'slaTask' => [
        'create' => 'SLA Task created at %CREATED%',
    ],

];