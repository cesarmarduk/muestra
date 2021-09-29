<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\States;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('states.index')) :
            $states = States::orderBy('name', 'ASC')->get();
            return view('dashboard.settings.states.index', compact('states'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    public function indexAjax(Request $request)
    {
        // if ($request->search === NULL OR $request->search === "") :
            $states = States::orderBy('name', 'ASC')->get();
        // else:
            // $states = States::where('name', 'LIKE', "%{$request->search}%")->orderBy('name', 'ASC')->get();
        // endif;

        $tag_states = [];

        foreach ($states as $state) :
            $tag_states[] = ['id' => $state->id, 'text' => $state->name];
        endforeach;

        return response()->json(['items' =>  $tag_states, 'total' => count($states)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        
        if($auth->can('states.create')) :
            return view('dashboard.settings.states.create');
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
        
        if($auth->can('states.store')) :
            $validator = Validator::make($request->all(), [
                'name'          => ['required', 'string', 'max:255', 'unique:states'],
                'abbreviation'  => ['required', 'string', 'max:10', 'unique:states']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.settings.states.create', compact('errors'));
            endif;

            States::create([
                'name'          => $request->name,
                'abbreviation'  => $request->abbreviation
            ]);

            return redirect()->route('dashboard.settings.state.index');
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
        
        if($auth->can('states.edit')) :
            $state = States::find(Crypt::decrypt($id));
            return view('dashboard.settings.states.edit', compact('state'));
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
        
        if($auth->can('states.update')) :
            $state = States::find(Crypt::decrypt($id));

            if ($state):
                if ($state->name === $request->name):
                    $validator = Validator::make($request->all(), [
                        'name'          => ['required', 'string', 'max:255'],
                        'abbreviation'  => ['required', 'string', 'max:10']
                    ]);
                else: 
                    $validator = Validator::make($request->all(), [
                        'name'          => ['required', 'string', 'max:255', 'unique:states'],
                        'abbreviation'  => ['required', 'string', 'max:10', 'unique:states']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();

                    return view('dashboard.settings.states.edit', compact('errors', 'state'));
                endif;

                States::where('id', '=', $state->id)->update([
                    'name'          => $request->name,
                    'abbreviation'  => $request->abbreviation,
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.state.index');
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
        
        if($auth->can('states.destroy')) :
            $state  = States::find(Crypt::decrypt($id));
            
            if ($state):
                States::where('id', '=', $state->id)->update([
                    'status'        => 'Inactive',
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.state.index');
            else: 
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
