<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::all();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
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
    public function store(Request $request)
    {
        try {
            $validatedAccount = $request->validate([
                'name' => 'required',
                'phone' => 'required',
            ]);

            $validatedAccount['uuid'] = Str::uuid();
            $customer = Customer::create($validatedAccount);

            $data = Customer::where('uuid', '=', $customer->uuid)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $data = Customer::where('uuid', '=', $uuid)->get();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
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
    public function update(Request $request, $uuid)
    {
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
            ]);

            $customer = Customer::findOrFail($uuid);
            // $validatedAccount['uuid'] = Str::uuid();
            $customer->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            $data = Customer::where('uuid', '=', $customer->uuid)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $uuid)
    {
        try {
            $customer = Customer::findOrFail($uuid);

            $data = $customer->delete($uuid);

            if ($data) {
                return ApiFormatter::createApi(200, 'Success Deleted Data');
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }
}
