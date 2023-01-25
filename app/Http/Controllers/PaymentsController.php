<?php

namespace App\Http\Controllers;

use App\BusinessProcess\uploadFile;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();

        if ($request->hasFile('scan_payment_document') && $request->paymenttitle_id == Payment::ID_YEAR_PAYMENT) {
            $path_scanlink = uploadFile::uploadFile($request->user_id, $user->secondname,$user->firstname, 'scan_year_payment_document', $request->file('scan_payment_document'));
        }

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->sum = $request->sum_payment;
        $payment->date = $request->date_payment;
        $payment->paymenttitle_id = $request->paymenttitle_id;
        $payment->scan_payment_document =  $path_scanlink;
        $payment->approve = Payment::APPROVE_FALSE;
        $payment->save();

        $request->session()->flash('status', 'Данные отправлены');

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payments = Payment::with('users')->where('paymenttitle_id', $id)->get();

        return view('finance.year-payments', compact(['payments', $payments]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::where('id', $id)->first();

        $payment->approve = Payment::APPROVE_TRUE;
        $payment->save();

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::where('id', $id)->first();

        $payment->approve = Payment::APPROVE_FALSE;
        $payment->save();

        return back();
    }
}
