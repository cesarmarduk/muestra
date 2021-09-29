<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Models\Settings\Permissions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        
        if($auth->can('permissions.index')) :
            $permissions = Permissions::orderBy('name', 'ASC')->get();
            return view('dashboard.settings.permissions.index', compact('permissions'));
        else: 
            return redirect()->route('errors.403');
        endif;
    }

    public function indexAjax(Request $request){
        $auth = Auth::user();

        if($auth->can('permissions.indexAjax')) :
            if ($request->search === NULL):
                $query  = DB::table('role_has_permissions')
                            ->select('permissions.name')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->where('role_has_permissions.role_id', '=', Crypt::decrypt($request->rol))
                            ->orderBy('permissions.name', 'ASC')
                            ->paginate($request->pagination);
            else: 
                $query  = DB::table('role_has_permissions')
                            ->select('permissions.name')
                            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                            ->where('role_has_permissions.role_id', '=', Crypt::decrypt($request->rol))
                            ->where('permissions.name', "LIKE", "%{$request->search}%")
                            ->orderBy('permissions.name', 'ASC')
                            ->paginate($request->pagination);
            endif;

            return response()->json($query, 200);
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
        
        if($auth->can('permissions.create')) :
            return view('dashboard.settings.permissions.create');
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
        
        if($auth->can('permissions.store')) :
            $validator = Validator::make($request->all(), [
                'name'  => ['required', 'string', 'max:255', 'unique:permissions']
            ]);

            if ($validator->fails()):
                $errors = $validator->errors();

                return view('dashboard.settings.permissions.create', compact('errors'));
            endif;

            Permissions::create([
                'name'          => $request->name,
                'guard_name'    => 'web'
            ]);

            return redirect()->route('dashboard.settings.permission.index');
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
        
        if($auth->can('permissions.edit')) :
            $permission = Permissions::find(Crypt::decrypt($id));
            return view('dashboard.settings.permissions.edit', compact('permission'));
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
        
        if($auth->can('permissions.update')) :
            $permission = Permissions::find(Crypt::decrypt($id));

            if ($permission):            
                if ($permission->name === $request->name):
                    $validator = Validator::make($request->all(), [
                        'name'  => ['required', 'string', 'max:255']
                    ]);
                else:
                    $validator = Validator::make($request->all(), [
                        'name'  => ['required', 'string', 'max:255', 'unique:permissions']
                    ]);
                endif;

                if ($validator->fails()):
                    $errors     = $validator->errors();
                    $permission = Permissions::find(Crypt::decrypt($id));

                    return view('dashboard.settings.permissions.edit', compact('errors', 'permission'));
                endif;

                Permissions::where('id', '=', $permission->id)->update([
                    'name'  => $request->name
                ]);

                return redirect()->route('dashboard.settings.permission.index');
            else :
                return redirect()->route('errors.403');
            endif;
        else: 
            return redirect()->route('errors.403');
        endif;
    }
}
