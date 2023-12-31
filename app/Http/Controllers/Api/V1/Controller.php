<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\RespondApi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use RespondApi;
    use ValidatesRequests;
}
