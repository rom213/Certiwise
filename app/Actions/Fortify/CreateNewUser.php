<?php

namespace App\Actions\Fortify;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Sentry\Response;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'company' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Tenant::class, 'id'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = new User();
        $user -> name = $input['name'];
        $user -> email = $input['email'];
        $user -> password = Hash::make($input['password']);

        DB::beginTransaction();
        try {
            $user->save();
            $companyName = $input['company'];
            $tenant = Tenant::create(['id' => $companyName]);
            $tenant->domains()->create(['domain' => "$companyName.certiwise.co"]);
            $tenant->users()->attach($user);

            $roleName = 'admin';
            $role = Role::where('name', $roleName)->first();
            $user->assignRole($role);
        } catch (\Error $exception) {
            DB::rollBack();
            report($exception);
        }
        DB::commit();

        return $user;
    }
}
