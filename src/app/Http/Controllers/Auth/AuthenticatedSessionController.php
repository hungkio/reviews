<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');

        return view('pages/auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $request->user()->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function getPublicReviews()
    {
        $results = DB::table('reviews')
            ->where('status', 1)
            ->where('order', 1)
            ->get();
        dd($results);

        $formattedResults = [];

        foreach ($results as $result) {
            $user = DB::table('customers')
                ->where('customers_id', $result->customer_id)
                ->first();
            $formattedResult = [
                'name' => $user->name,
                'star' => $result->star,
                'social' => $result->source,
                'avatar' => 'https://pbs.twimg.com/profile_images/1618575477781807105/iDuRlqTe_400x400.jpg',
                'review' => $result->review
            ];

            $formattedResults[] = $formattedResult;
        }

        dd($formattedResults);

        echo json_encode($formattedResults);

    }
}
