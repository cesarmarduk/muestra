<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Settings\User;
use App\Models\Management\Signers;
use App\Models\Management\Contrats;
use App\Models\Management\ContratsSigners;
use App\Models\Management\Policies;
use App\Models\Management\PoliciesSigners;
use App\Models\Management\PoliciesFiles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class FileController extends Controller
{
    private function root(){ 
        return 'app/';
    }

    public function getAvatar($id)
    {
        $user = User::fin(Crypt::decrypt($id));

        if ($user):
            $file = Files::find($user->file_id);

            if ($file):
                $path = storage_path($this->root().$file->path);
                return $this->fileResponse($path);
            endif;
        endif;
    }

    public function getPdf($id)
    {
        $contrat = Contrats::find(Crypt::decrypt($id));

        if ($contrat):
            $file = Files::find($contrat->file_id);
            
            if ($file):
                $path = storage_path($this->root().$file->path);

                return $this->fileResponse($path);
            endif;
        endif;
    }
    
    public function getPolicyPdf($id)
    {
        $policy = Policies::find(Crypt::decrypt($id));

        if ($policy):
            $file = Files::find($policy->file_id);
            
            if ($file):
                $path = storage_path($this->root().$file->path);

                return $this->fileResponse($path);
            endif;
        endif;
    }
    
    public function getPolicyFiles($file_id)
    {
        $file = Files::find(Crypt::decrypt($file_id));
        
        if ($file):
            $path = storage_path($this->root().$file->path);

            return $this->fileResponse($path);
        endif;
    }
    
    public function getFileFirm($document_id, $contact_id, $param)
    {
        $document_firm = DocumentsFirms::where('document_id', '=', Crypt::decrypt($document_id))->where('contact_id', '=', Crypt::decrypt($contact_id))->get();

        if ($document_firm):
            if ($param === 'photo_profile'):
                $file = Files::find($document_firm[0]->photo_profile);
            elseif ($param === 'photo_dni'):
                $file = Files::find($document_firm[0]->photo_dni);
            elseif ($param === 'photo_dni_reverse'):
                $file = Files::find($document_firm[0]->photo_dni_reverse);
            elseif ($param === 'firm'):
                $file = Files::find($document_firm[0]->firm);
            endif;
            
            if ($file):
                $path = storage_path($this->root().$file->path);
                return $this->fileResponse($path);
            endif;
        endif;
    }

    public function fileResponse($path)
    {
        if(!\File::exists($path)):
            route('dashboard.errors.404');
        endif;

        $file = \File::get($path);
        $type = \File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
