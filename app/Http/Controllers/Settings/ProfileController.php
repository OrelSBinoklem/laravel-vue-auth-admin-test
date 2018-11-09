<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\ChangeEmail;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        if ($user instanceof MustVerifyEmail &&
            ! $user->isOAuth() &&
            $request->input('email') !== $user->email) {

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->email_verified_at = null;
            $user->save();

            event(new ChangeEmail($user));

            $user->oauth = $user->isOAuth();
            return $user;

        }


        tap($user)->update($request->only('name', 'email'));
        $user->oauth = $user->isOAuth();
        return $user;
    }
}
