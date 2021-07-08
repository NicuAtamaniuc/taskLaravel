<?php

namespace App\Http\Controllers;
use App\Raion;
use App\IBAN;
use App\User;
use App\Roles;
use App\Role_user;
use App\eco_ca;
use App\Localitate;
use DB;

use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
        $raioane = Raion::all();

        if(\auth::guest())
        {
            return view('welcome')->with([
                'raioane' => $raioane
            ]);
        }

        elseif(\auth::user())
        {
            $user = User::find(auth()->id());
            $eco = eco_ca::all();
            $roluri = Roles::all();



            $ani = IBAN::distinct()->select('anul')->get();
    
            foreach($user->roles as $rolul)
            $rol = $rolul->rol;
    
            return view('welcome')->with([
                'raioane' => $raioane,
                'rol' => $rol,
                'eco' => $eco,
                'ani' => $ani
            ]);
        }
    }

    public function atribuireLocalitate(Request $request)
    {
        $data = Localitate::select('kd_local','name_s')->where('kd_raion',$request->id)->get();
        return response()->json($data);
    }

    public function EcoAtribuire(Request $request)
    {
        $data = IBAN::join('eco_ca', 'eco_ca.kd_eco', '=', 'i_b_a_n_s.kd_eco')
                    ->distinct()
                    ->select('eco_ca.kd_eco','eco_ca.label_md')
                    ->where('i_b_a_n_s.anul',$request->anul)
                    ->get();
        return response()->json($data);
    }

    public function IBANadauga(Request $request)
    {
        $iban = $request->input('iban');
        $data = new IBAN;
        $data->anul = $request->input('anul');
        $data->kd_eco = $request->input('eco');
        $data->kd_local = $request->input('localitate');
        $data->iban = 'MD'.$iban;
        $data->save();
        return back()->with('adaugat', 'Inregistrarea a fost adaugata cu succes!');
    }

    public function IBANread(Request $request)
    {
        $user = User::find(auth()->id());
        $fulleco = eco_ca::all();
        $localitati = Localitate::all();

        foreach($user->roles as $rol)
        $rol = $rol->rol;

        $an = $request->input('anul');
        $eco = $request->input('eco');
        $loclaitate = $request->input('localitate');
            
        $select = IBAN::where('anul',$an)
                        ->where('kd_eco',$eco)
                        ->where('kd_local',$loclaitate)
                        ->get();
        
        $count = count($select);                   
        return view('read')->with([
            'select' => $select,
            'rol' => $rol,
            'count' => $count,
            'fulleco' => $fulleco,
            'localitati' => $localitati
        ]);
    }

    public function delete(Request $request)
    {
        $an = $request->input('anul2');
        $eco = $request->input('eco2');
        $loclaitate = $request->input('localitate');
            
        $select = IBAN::where('anul',$an)
                        ->where('kd_eco',$eco)
                        ->where('kd_local',$loclaitate)
                        ->delete();
        
        return back()->with('sters', 'Datele au fost sterse!');
    }

    public function update(Request $request)
    {
        $an = $request->input('an');
        $eco = $request->input('eco');
        $loclaitate = $request->input('localitate');
        $ibanNou = $request->input('iban');
        $iban = 'MD'.$ibanNou;
            
        DB::table('i_b_a_n_s')->where('anul',$an)->where('kd_eco',$eco)->where('kd_local',$loclaitate)
                ->update([
                    'iban' => $iban
                   ]);
        return redirect()->route('welcome')->with('actualizat', 'Datele au fost actualizate!');
    }

    public function rolAtr()
    {
        $user = User::find(auth()->id());
        $allUser = User::all();
        $eco = eco_ca::all();
        $roluri = Roles::all();

        $ani = IBAN::distinct()->select('anul')->get();

        foreach($user->roles as $rol)
        $rol = $rol->rol;

        return view('roluri')->with([
            'rol' => $rol,
            'eco' => $eco,
            'ani' => $ani,
            'roluri' => $roluri,
            'allUser' =>$allUser,
            'user' => $user
        ]);
    }

    public function set(Request $request)
    {
        $utilizatori = $request->input('utilizatori');
        $rol = $request->input('roluri');
            
        DB::table('role_users')->where('id_user',$utilizatori)
                ->update([
                    'id_rol' => $rol
                   ]);
        return redirect()->route('welcome')->with('setat', 'Rolul a fost atribuit!');
    }

    public function operator_raion(Request $request)
    {
        $user = User::find(auth()->id());
        $fulleco = eco_ca::all();
        $localitati = Localitate::all();

        foreach($user->roles as $rol)
        $rol = $rol->rol;

        $an = $request->input('anul');
        $eco = $request->input('eco');
        $loclaitate = $request->input('localitate');
            
        $select = IBAN::where('anul',$an)
                        ->where('kd_eco',$eco)
                        ->where('kd_local',$loclaitate)
                        ->get();
        
        $count = count($select);                   
        return view('read_operator_raion')->with([
            'select' => $select,
            'rol' => $rol,
            'count' => $count,
            'fulleco' => $fulleco,
            'localitati' => $localitati
        ]);
    }

    public function simplu_operator(Request $request)
    {
        $user = User::find(auth()->id());
        $fulleco = eco_ca::all();
        $localitati = Localitate::all();

        foreach($user->roles as $rol)
        $rol = $rol->rol;

        $an = $request->input('anul');
        $eco = $request->input('eco');
        $loclaitate = $request->input('localitate');
            
        $select = IBAN::where('anul',$an)
                        ->where('kd_eco',$eco)
                        ->where('kd_local',$loclaitate)
                        ->get();
        
        $count = count($select);                   
        return view('read_operator_raion')->with([
            'select' => $select,
            'rol' => $rol,
            'count' => $count,
            'fulleco' => $fulleco,
            'localitati' => $localitati
        ]);
    }

    public function test()
    {
        foreach($user->roles as $rol)
        $rol = $rol->rol;
    }
}
