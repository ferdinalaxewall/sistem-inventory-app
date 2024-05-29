<?php

namespace App\Http\Controllers\LandingPage;

use Illuminate\Http\Request;
use App\Models\CustomerMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LandingPage\SendCustomerMessageRequest;

class MainController extends Controller
{
    public function home()
    {
        return view('landing-page.index');
    }

    public function sendCustomerMessage(SendCustomerMessageRequest $request)
    {
        $requestDTO = $request->validated();
        try {
            $requestDTO['customer_ip'] = $request->getClientIp();
            CustomerMessage::create($requestDTO);

            return redirect(route('home'))->with('toastSuccess', 'Terima kasih sudah menghubungi kami, tim kami akan segera menghubungi anda');
        } catch (\Throwable $th) {
            return redirect(route('home'))->with('toastSuccess', 'Terjadi kesalahan saat mengirim pesan');
        }
    }
}
