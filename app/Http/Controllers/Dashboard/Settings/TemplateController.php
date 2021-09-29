<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\Types;
use App\Models\Settings\Templates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('templates.index')):
            $templates = Templates::select('types.name AS typeName', 'templates.*')
                            ->join('types', 'types.id', '=', 'templates.type_id')
                            ->where('templates.status', '=', 'Active')
                            ->orderBy('types.name', 'ASC')
                            ->orderBy('templates.name', 'ASC')
                            ->get();

            return view('dashboard.settings.templates.index', compact('templates'));
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
        
        if($auth->can('templates.create')):
            $types = Types::where('status', '=', 'Active')->orderBy('name', 'ASC')->get();
            return view('dashboard.settings.templates.create', compact('types'));
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
        
        if($auth->can('templates.store')):
            $validator = Validator::make($request->all(), [
                'name'      => ['required', 'string', 'max:255', 'unique:templates'],
                'template'  => ['required'],
                'type_id'   => ['required']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();
                $types = Types::where('status', '=', 'Active')->orderBy('name', 'ASC')->get();

                return view('dashboard.settings.templates.create', compact('errors', 'types'));
            endif;

            Templates::create([
                'name'      => $request->name,
                'template'  => $request->template,
                'type_id'   => $request->type_id,
                'user_id'   => Auth::user()->id,
            ]);

            return redirect()->route('dashboard.settings.template.index');
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
        
        if($auth->can('templates.edit')):
            $template   = Templates::find(Crypt::decrypt($id));
            $types      = Types::where('status', '=', 'Active')->orderBy('name', 'ASC')->get();
            return view('dashboard.settings.templates.edit', compact('template', 'types'));
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
        
        if($auth->can('templates.update')):
            $template = Templates::find(Crypt::decrypt($id));

            if($template):
                if ($template->name === $request->name):
                    $validator = Validator::make($request->all(), [
                        'name'      => ['required', 'string', 'max:255'],
                        'template'  => ['required'],
                        'type_id'   => ['required']
                    ]);
                else: 
                    $validator = Validator::make($request->all(), [
                        'name'      => ['required', 'string', 'max:255', 'unique:templates'],
                        'template'  => ['required'],
                        'type_id'   => ['required']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();
                    $types      = Types::where('status', '=', 'Active')->orderBy('name', 'ASC')->get();

                    return view('dashboard.settings.templates.edit', compact('errors', 'template', 'types'));
                endif;

                Templates::where('id', '=', $template->id)->update([
                    'name'          => $request->name,
                    'template'      => $request->template,
                    'type_id'       => $request->type_id,
                    'id_user'       => Auth::user()->id,
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.template.index');
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
        
        if($auth->can('templates.destroy')):
            $template   = Templates::find(Crypt::decrypt($id));
            
            if ($template):
                Templates::where('id', '=', $template->id)->update([
                    'status'        => 'Inactive',
                    'updated_at'    => date('Y-m-d')
                ]);

                return redirect()->route('dashboard.settings.template.index');
            else: 
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
