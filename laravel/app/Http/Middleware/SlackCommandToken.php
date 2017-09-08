<?php

namespace App\Http\Middleware;

use Closure;

class SlackCommandToken {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->input('token') === env('SLACK_COMMAND_TOKEN')) {
            return $next($request);
        }

        return response('This resource is for Slack only.', 403);
    }
}
