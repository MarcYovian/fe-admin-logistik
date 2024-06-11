<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowingStep1Request;
use App\Http\Requests\StoreBorrowingStep2Request;
use App\Services\APIService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $respAdmin = APIService::GetDataByEndPoint('admins/current');
        $respBorrowings = APIService::GetDataByEndPoint('borrowings');
        if ($respAdmin['statusCode'] >= 400 || $respBorrowings['statusCode'] >= 400) {
            return redirect()->route('dashboard');
        }
        $admin = $respAdmin['bodyContents']['data'];
        $borrowings = $respBorrowings['bodyContents']['data'];

        // Filter borrowings by event_date
        $borrowings = array_filter($borrowings, function ($borrowing) {
            return Carbon::parse($borrowing['event_date'])->isToday() || Carbon::parse($borrowing['event_date'])->isFuture();
        });

        $data = [
            'admin' => $admin,
            'url' => "borrowings",
            'active' => "borrowings",
            'borrowings' => $borrowings,
        ];

        return view('admin.borrowings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createStep1()
    {
        $borrowingData = Session::get('borrowing_step1', []);
        $respAdmin = APIService::GetDataByEndPoint('admins/current');
        if ($respAdmin['statusCode'] >= 400) {
            return redirect()->route('dashboard');
        }
        $admin = $respAdmin['bodyContents']['data'];
        $data = [
            'admin' => $admin,
            'url' => "Add New Borrowings",
            'active' => "borrowings",
            'borrowingData' => $borrowingData,
        ];

        // dd($data);

        return view('admin.borrowings.create_step1', $data);
    }
    public function createStep2()
    {
        if (!Session::has('borrowing_step1')) {
            return redirect()->route('borrowings.create.step1');
        }
        $respAdmin = APIService::GetDataByEndPoint('admins/current');
        if ($respAdmin['statusCode'] >= 400) {
            return redirect()->route('dashboard');
        }
        $admin = $respAdmin['bodyContents']['data'];
        $data = [
            'admin' => $admin,
            'url' => "Add New Borrowings",
            'active' => "borrowings",
        ];

        return view('admin.borrowings.create_step2', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeStep1(StoreBorrowingStep1Request $request)
    {
        $validated = $request->validated();
        Session::put('borrowing_step1', $validated);

        return redirect()->route('borrowings.create.step2');
    }
    public function storeStep2(StoreBorrowingStep2Request $request)
    {
        $validated = $request->validated();
        dd($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
