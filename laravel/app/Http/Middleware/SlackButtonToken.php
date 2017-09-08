<?php

namespace App\Http\Middleware;

use Closure;

class SlackButtonToken {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $payload = json_decode($request->input('payload'), true);

        if ($payload['token'] === env('SLACK_COMMAND_TOKEN')) {
            return $next($request);
        }

        return response('This resource is for Slack only.', 403);
    }
}
