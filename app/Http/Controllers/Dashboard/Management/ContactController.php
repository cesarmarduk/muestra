<?php

namespace App\Http\Controllers\Dashboard\Management;

use App\Models\Management\Contacts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('contacts.index')) :
            $contacts = Contacts::where('status', '=', 'Active')->orderBy('fullname', 'ASC')->get();
        else:
            $contacts = Contacts::where('status', '=', 'Active')->where('user_id', '=', Auth::user()->id)->orderBy('fullname', 'ASC')->get();
        endif;

        return view('dashboard.management.contacts.index', compact('contacts'));
    }
    
    public function indexAjax(Request $request)
    {
        $auth = Auth::user();
        
        if($auth->can('contacts.index')) :
            if ($request->search === NULL OR $request->search === "") :
                $contacts = Contacts::where('status', '=', 'Active')->orderBy('fullname', 'ASC')->get();
            else:
                $contacts = Contacts::where('status', '=', 'Active')->where('fullname', 'LIKE', "%{$request->search}%")->orderBy('fullname', 'ASC')->get();
            endif;
        else:
            if ($request->search === NULL OR $request->search === "") :
                $contacts = Contacts::where('status', '=', 'Active')->where('user_id', '=', Auth::user()->id)->orderBy('fullname', 'ASC')->get();
            else: 
                $contacts = Contacts::where('status', '=', 'Active')->where('user_id', '=', Auth::user()->id)->where('fullname', 'LIKE', "%{$request->search}%")->orderBy('fullname', 'ASC')->get();
            endif;
        endif;

        $tag_contacts = [];

        foreach ($contacts as $contact) :
            $tag_contacts[] = ['id' => $contact->id, 'text' => $contact->fullname];
        endforeach;

        return response()->json(['items' =>  $tag_contacts, 'total' => count($contacts)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.management.contacts.create');
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
            'fullname'  => ['required', 'string'],
            'email'     => ['required', 'email', 'max:255', 'unique:contacts']
        ]);

        if ($validator->fails()):
            $errors = $validator->errors();

            return view('dashboard.management.contacts.create', compact('errors'));
        endif;

        $address = NULL;

        if ($request->address_id !== NULL): 
            $address = $request->address_id;
        endif;

        Contacts::create([
            'fullname'      => $request['fullname'],
            'email'         => $request['email'],
            'address_id'    => $address,
            'user_id'       => Auth::user()->id
        ]);

        return redirect()->route('dashboard.management.contact.index');
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
        $contact = Contacts::find(Crypt::decrypt($id));
        return view('dashboard.management.contacts.edit', compact('contact'));
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
        $contact = Contacts::find(Crypt::decrypt($id));

        if ($contact):
            if ($contact->email === $request->email):
                $validator = Validator::make($request->all(), [
                    'fullname'  => ['required', 'string'],
                    'email'     => ['required', 'email', 'max:255']
                ]); 
            else: 
                $validator = Validator::make($request->all(), [
                    'fullname'  => ['required', 'string'],
                    'email'     => ['required', 'email', 'max:255', 'unique:contacts']
                ]);
            endif;

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.management.contacts.edit', compact('errors', 'contact'));
            endif;

            $address = NULL;

            if ($request->address_id !== NULL): 
                $address = $request->address_id;
            endif;
            
            Contacts::where('id', '=', $contact->id)->update([
                'fullname'      => $request['fullname'],
                'email'         => $request['email'],
                'address_id'    => $address,
                'id_user'       => Auth::user()->id,
                'updated_at'    => date('Y-m-d')
            ]);

            return redirect()->route('dashboard.management.contact.index');
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
        $contact  = Contacts::find(Crypt::decrypt($id));
            
        if ($contact):
            Contacts::where('id', '=', $contact->id)->update([
                'status'        => 'Inactive',
                'updated_at'    => date('Y-m-d')
            ]);

            return redirect()->route('dashboard.management.contact.index');
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}