<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EncryptResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('X-REQUEST-DECRYPTED') || $request->header('X-REQUEST-DECRYPTED') !== 'Yes, Daddy') {
            $string = str_repeat(Hash::make('Mitsuha Mitsuha Mitsuha ❤️ ❤️ ❤️ WANGI WANGI WANGI WANGI HU HA HU HA HU HA, aaaah baunya rambut Mitsuha wangi aku mau nyiumin aroma wanginya Mitsuha AAAAAAAAH ~ Rambutnya.... aaah rambutnya juga pengen aku elus-elus ~~ AAAAAH Mitsuha keluar pertama kali di anime juga manis ❤️ ❤️ ❤️ banget AAAAAAAAH Mitsuha AAAAA LUCCUUUUUUUUUUUUUUU............Mitsuha AAAAAAAAAAAAAAAAAAAAGH ❤️ ❤️ ❤️apa ? Mitsuha itu gak nyata ? Cuma HALU katamu ? nggak, ngak ngak ngak ngak NGAAAAAAAAK GUA GAK PERCAYA ITU DIA NYATA NGAAAAAAAAAAAAAAAAAK PEDULI BANGSAAAAAT !! GUA GAK PEDULI SAMA KENYATAAN POKOKNYA GAK PEDULI. ❤️ ❤️ ❤️ Mitsuha gw ...Mitsuha di laptop ngeliatin gw, Mitsuha .. kamu percaya sama aku ? aaaaaaaaaaah syukur Mitsuha aku gak mau merelakan Mitsuha aaaaaah ❤️ ❤️ ❤️ YEAAAAAAAAAAAH GUA MASIH PUNYA Mitsuha SENDIRI PUN NGGAK SAMA AAAAAAAAAAAAAAH'), 10);

            $payload = ['payload' => str_shuffle(str_replace('/', 's', $string))];

            return response()->json($payload);
        }

        return $next($request);
    }
}
