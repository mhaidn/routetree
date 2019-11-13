<?php

namespace RouteTreeTests\Feature\Controllers\Nested;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NestedController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __call($name, $arguments)
    {
        return json_encode([
            'id' => route_tree()->getCurrentNode()->getId(),
            'controller' => 'nested',
            'function' => $name,
            'method' => \Request::getMethod(),
            'path' => trim(\Request::getPathInfo(),'/'),
            'locale' => app()->getLocale(),
            'payload' => route_tree()->getCurrentNode()->payload,
            'title' => route_tree()->getCurrentNode()->payload->getTitle(),
            'navTitle' => route_tree()->getCurrentNode()->payload->getNavTitle(),
            'h1Title' => route_tree()->getCurrentNode()->payload->getH1Title()
        ]);
    }

}
