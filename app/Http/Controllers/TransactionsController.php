<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $d['title'] = 'Transactions List';
        $d['model'] = Transactions::orderBy('time', 'desc')->paginate(10);
        return view('transactions.transactionsList', $d);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=Transactions::destroy($id);
        return redirect()->route('transactions-list')->with('success', 'Transaction deleted successfully.');
    }
}
