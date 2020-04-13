<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => 3,
            'redirect_uri' => 'http://personal.test/authorizations/callback',
            'response_type' => 'code',
            'scope' => 'bing',
        ]);

        return redirect('http://provider.test/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $client = new Client();

        $response = $client->post('http://provider.test/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 3,
                'client_secret' => 'MV61aRwNaexSG2zGIa33NA8bvfjJALCwyNBTQDuS',
                'redirect_uri' => 'http://personal.test/authorizations/callback',
                'code' => $request->input('code'),
            ],
        ]);

        return $response->getBody();
    }


}
