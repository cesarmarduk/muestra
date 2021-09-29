<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\Roles;
use App\Models\Settings\Permissions;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('roles.index')) :
            $roles = Roles::orderBy('name', 'ASC')->get();
            return view('dashboard.settings.roles.index', compact('roles'));
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
        
        if($auth->can('roles.create')) :
            $array = [];
            $permissions = Permissions::orderBy('name', 'ASC')->get();

            foreach($permissions as $key => $row):
                $title   = explode('.', $row['name']);
                $array[] = strtoupper($title[0]);
            endforeach;

            $titles = array_unique($array);

            return view('dashboard.settings.roles.create', compact('titles', 'permissions'));
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
        
        if($auth->can('roles.store')) :
            $validator = Validator::make($request->all(), [
                'name'  => ['required', 'string', 'max:255', 'unique:roles']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.settings.roles.create', compact('errors'));
            endif;

            $rol = Roles::create([
                'name'          => $request->name,
                'guard_name'    => 'web'
            ]);

            if ($request->permissions !== NULL):
                $role = Role::find($rol->id);

                foreach ($request->permissions as $permission) :
                    $role->givePermissionTo($permission);
                endforeach;
            endif;

            return redirect()->route('dashboard.settings.role.index');
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
        
        if($auth->can('roles.edit')) :
            $array = [];
            $permissions = Permissions::orderBy('name', 'ASC')->get();
            $role        = Roles::find(Crypt::decrypt($id));

            foreach($permissions as $key => $row):
                $title   = explode('.', $row['name']);
                $array[] = strtoupper($title[0]);
            endforeach;

            $titles = array_unique($array);

            $role_permissions = DB::table('role_has_permissions')->where('role_id', Crypt::decrypt($id))->get();

            return view('dashboard.settings.roles.edit', compact('titles', 'permissions', 'role', 'role_permissions'));
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
        
        if($auth->can('roles.update')) :
            $rol = Roles::find(Crypt::decrypt($id));
            
            if($rol):            
                if ($rol->name === $request->name):
                    $validator = Validator::make($request->all(), [
                        'name'  => ['required', 'string', 'max:255']
                    ]);
                else:
                    $validator = Validator::make($request->all(), [
                        'name'  => ['required', 'string', 'max:255', 'unique:roles']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors = $validator->errors();

                    return view('dashboard.settings.roles.edit', compact('errors', 'role'));
                endif;

                Roles::where('id', '=', $rol->id)->update([
                    'name'  => $request->name
                ]);

                if ($request->permissions !== NULL):            
                    DB::table('role_has_permissions')->where('role_id', '=', $rol->id)->delete();

                    $role = Role::find($rol->id);

                    foreach ($request->permissions as $permission) :
                        $role->givePermissionTo($permission);
                    endforeach;
                endif;

                return redirect()->route('dashboard.settings.role.index');
            else :
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
