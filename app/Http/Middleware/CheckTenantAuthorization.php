<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedException;
use Illuminate\Support\Facades\DB;

class CheckTenantAuthorization
{
    public function handle(Request $request, Closure $next)
    {
        $currentTenantId = tenant('id');

        $userId = auth()->id();

        if (!$this->userHasPermissionForTenant($userId, $currentTenantId)) {
            return response()->json(['message' => 'unauthorized'], 403);
        }

        return $next($request);
    }

    private function userHasPermissionForTenant($userId, $tenantId)
    {
        $permission = DB::table('tenant_user')
            ->where('user_id', $userId)
            ->where('tenant_id', $tenantId)
            ->first();

        return $permission !== null;
    }
}
