<?php

namespace App\Http\Controllers\Api;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    public function __invoke(Request $request)
    {
        $records =  ActivityLog::latest()->paginate(50)->appends(request()->except('page'));

        $output = $records->toArray();
        $output['data'] = $records->groupBy([
            'account_id', function($item){
                return $item->message === 'Borrower updated application' ? [$item->message] : false;
            }
        ]);

        $output['pagination_elements'] = $records->links()->getData()['elements'];

        return $output;
    }
}
