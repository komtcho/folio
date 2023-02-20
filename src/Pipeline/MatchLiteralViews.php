<?php

namespace Laravel\Folio\Pipeline;

use Closure;
use Illuminate\Support\Facades\View;
use Laravel\Folio\Router;

class MatchLiteralViews
{
    /**
     * Invoke the routing pipeline handler.
     */
    public function __invoke(State $state, Closure $next): mixed
    {
        // Literal view match... must also be last segment...
        if ($state->onLastUriSegment() &&
            file_exists($path = $state->currentDirectory().'/'.$state->currentUriSegment().'.blade.php')) {
            Router::ensureNoDirectoryTraversal($path, $state->mountPath);

            return new MatchedView($path, $state->data);
        }

        return $next($state);
    }
}
