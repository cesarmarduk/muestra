<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\Types;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('types.index')) :
            $types = Types::where('status', '=', 'Active')->orderBy('name', 'ASC')->get();
            return view('dashboard.settings.types.index', compact('types'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        
        if($auth->can('types.create')) :
            return view('dashboard.settings.types.create');
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = Auth::user();
        
        if($auth->can('types.store')) :
            $validator = Validator::make($request->all(), [
                'name'  => ['required', 'string', 'max:255', 'unique:types'],
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.settings.types.create', compact('errors'));
            endif;

            Types::create([
                'name'      => $request->name,
                'user_id'   => Auth::user()->id
            ]);

            return redirect()->route('dashboard.settings.type.index');
        else: 
            return redirect()->route('errors.403');
        endif;
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
        $auth = Auth::user();
        
        if($auth->can('types.edit')) :
            $type = Types::find(Crypt::decrypt($id));
            return view('dashboard.settings.types.edit', compact('type'));
        else: 
            return redirect()->route('errors.403');
        endif;
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
        $auth = Auth::user();
        
        if($auth->can('types.update')) :
            $type = Types::find(Crypt::decrypt($id));

            if ($type): 
                if ($type->name === $request->name):
                    $validator = Validator::make($request->all(), [
                        'name'  => ['required', 'string', 'max:255']
                    ]);
                else:
                    $validator = Validator::make($request->all(), [
                        'name'  => ['required', 'string', 'max:255', 'unique:types']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();

                    return view('dashboard.settings.types.edit', compact('errors', 'type'));
                endif;

                Types::where('id', '=', $type->id)->update([
                    'name'          => $request->name,
                    'id_user'       => Auth::user()->id,
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.type.index');
            else: 
                return redirect()->route('errors.403');
            endif;
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
        $auth = Auth::user();
        
        if($auth->can('types.destroy')) :
            $type  = Types::find(Crypt::decrypt($id));
            
            if ($type):
                Types::where('id', '=', $type->id)->update([
                    'status'        => 'Inactive',
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.type.index');
            else: 
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
