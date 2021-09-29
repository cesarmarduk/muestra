<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Management\Address;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('address.index')) :
            $address = Address::where('status', '=', 'Active')->orderBy('id', 'DESC')->get();
        else:
            $address = Address::where('status', '=', 'Active')->where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        endif;

        return view('dashboard.management.address.index', compact('address'));
    }
    
    public function indexAjax(Request $request)
    {
        $auth = Auth::user();
        
        if($auth->can('address.index')) :
            if ($request->search === NULL OR $request->search === "") :
                $address = Address::where('status', '=', 'Active')->orderBy('id', 'DESC')->get();
            else:
                $address = Address::where('status', '=', 'Active')->where('address', 'LIKE', "%{$request->search}%")->orderBy('id', 'DESC')->get();
            endif;
        else:
            if ($request->search === NULL OR $request->search === "") :
                $address = Address::where('status', '=', 'Active')->where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
            else: 
                $address = Address::where('status', '=', 'Active')->where('user_id', '=', Auth::user()->id)->where('address', 'LIKE', "%{$request->search}%")->orderBy('id', 'DESC')->get();
            endif;
        endif;

        $tag_address = [];

        foreach ($address as $addres) :
            $tag_address[] = ['id' => $addres->id, 'text' => $addres->address];
        endforeach;

        return response()->json(['items' =>  $tag_address, 'total' => count($address)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.management.address.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'  => ['required']
        ]);

        if ($validator->fails()):
            $errors = $validator->errors();

            return view('dashboard.management.address.create', compact('errors'));
        endif;

        Address::create([
            'address'   => $request->address,
            'user_id'   => Auth::user()->id
        ]);

        return redirect()->route('dashboard.management.address.index');
    }
    
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'  => ['required']
        ]);

        if ($validator->fails()):
            $errors = $validator->errors();

            return response()->json($errors, 422);
        endif;

        Address::create([
            'address'   => $request->address,
            'user_id'   => Auth::user()->id
        ]);

        return response()->json(true, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::find(Crypt::decrypt($id));
        return view('dashboard.management.address.edit', compact('address'));
    }
    
    public function editAjax(Request $request)
    {
        $address = Address::find(Crypt::decrypt($request->val));
        return response()->json(['id' => $address->id, 'address' => $address->address], 200);
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
        $address = Address::find(Crypt::decrypt($id));

        if ($address):
            $validator = Validator::make($request->all(), [
                'address'  => ['required']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.management.address.edit', compact('errors', 'address'));
            endif;

            Address::where('id', '=', $address->id)->update([
                'address'       => $request->address,
                'id_user'       => Auth::user()->id,
                'updated_at'    => date('Y-m-d')
            ]);

            return redirect()->route('dashboard.management.address.index');
        else:
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address  = Address::find(Crypt::decrypt($id));
            
        if ($address):
            Address::where('id', '=', $address->id)->update([
                'status'        => 'Inactive',
                'updated_at'    => date('Y-m-d')
            ]);

            return redirect()->route('dashboard.management.address.index');
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
