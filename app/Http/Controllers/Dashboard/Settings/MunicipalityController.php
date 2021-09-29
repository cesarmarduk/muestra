<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\States;
use App\Models\Settings\Municipalities;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('municipalities.index')):
            $municipalities = Municipalities::select('states.name AS stateName', 'municipalities.*')
                            ->join('states', 'states.id', '=', 'municipalities.state_id')
                            ->orderBy('states.name', 'ASC')
                            ->orderBy('municipalities.name', 'ASC')
                            ->get();

            return view('dashboard.settings.municipalities.index', compact('cities'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    public function indexAjax(Request $request)
    {
        if ($request->search === NULL OR $request->search === "") :
            $municipalities = Municipalities::orderBy('name', 'ASC')->get();
        else:
            $municipalities = Municipalities::where('name', 'LIKE', "%{$request->search}%")->orderBy('name', 'ASC')->get();
        endif;

        $tag_cities = [];

        foreach ($municipalities as $city) :
            $tag_cities[] = ['id' => $city->id, 'text' => $city->name];
        endforeach;

        return response()->json(['items' =>  $tag_cities, 'total' => count($municipalities)], 200);
    }
    
    public function indexAjaxByState(Request $request)
    {
        if ($request->search === NULL OR $request->search === "") :
            $municipalities = Municipalities::where('state_id', '=', $request->state)->orderBy('name', 'ASC')->get();
        else:
            $municipalities = Municipalities::where('state_id', '=', $request->state)->where('name', 'LIKE', "%{$request->search}%")->orderBy('name', 'ASC')->get();
        endif;

        $tag_cities = [];

        foreach ($municipalities as $city) :
            $tag_cities[] = ['id' => $city->id, 'text' => $city->name];
        endforeach;

        return response()->json(['items' =>  $tag_cities, 'total' => count($municipalities)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        
        if($auth->can('municipalities.create')):
            $states = States::orderBy('name', 'ASC')->get();
            return view('dashboard.settings.municipalities.create', compact('states'));
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
        
        if($auth->can('municipalities.store')):
            $validator = Validator::make($request->all(), [
                'name'          => ['required', 'string', 'max:255'],
                'abbreviation'  => ['required', 'string', 'max:10', 'unique:cities'],
                'state_id'      => ['required']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();
                $states = States::orderBy('name', 'ASC')->get();

                return view('dashboard.settings.municipalities.create', compact('errors', 'states'));
            endif;

            Municipalities::create([
                'name'          => $request->name,
                'abbreviation'  => $request->abbreviation,
                'state_id'      => $request->state_id
            ]);

            return redirect()->route('dashboard.settings.city.index');
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
        
        if($auth->can('municipalities.edit')):
            $city   = Municipalities::find(Crypt::decrypt($id));
            $states = States::orderBy('name', 'ASC')->get();
            return view('dashboard.settings.municipalities.edit', compact('city', 'states'));
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
        
        if($auth->can('municipalities.update')):
            $city = Municipalities::find(Crypt::decrypt($id));

            if ($city):            
                if ($city->abbreviation === $request->abbreviation):
                    $validator = Validator::make($request->all(), [
                        'name'          => ['required', 'string', 'max:255'],
                        'abbreviation'  => ['required', 'string', 'max:10'],
                        'state_id'      => ['required']
                    ]);
                else: 
                    $validator = Validator::make($request->all(), [
                        'name'          => ['required', 'string', 'max:255'],
                        'abbreviation'  => ['required', 'string', 'max:10', 'unique:cities'],
                        'state_id'      => ['required']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();
                    $states = States::orderBy('name', 'ASC')->get();

                    return view('dashboard.settings.municipalities.edit', compact('errors', 'city', 'states'));
                endif;

                Municipalities::where('id', '=', $city->id)->update([
                    'name'          => $request->name,
                    'abbreviation'  => $request->abbreviation,
                    'state_id'      => $request->state_id,
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.city.index');
            else :
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
        
        if($auth->can('municipalities.destroy')):
            $city = Municipalities::find(Crypt::decrypt($id));
            
            if ($city):
                Municipalities::where('id', '=', $city->id)->update([
                    'status'        => 'Inactive',
                    'updated_at'    => date('Y-m-d')
                ]);
                
                return redirect()->route('dashboard.settings.city.index');
            else: 
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
