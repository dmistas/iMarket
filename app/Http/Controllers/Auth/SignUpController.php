<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Http\RedirectResponse;

class SignUpController extends Controller
{

    public function page()
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // TODO make DTOs
        try {
            $action($request->validated());
        } catch (\Exception $e) {
            logger()->error('Error within RegisterNewUserAction', ['exception' => $e]);
        }


        return redirect()
            ->intended(route('home'));
    }

}
