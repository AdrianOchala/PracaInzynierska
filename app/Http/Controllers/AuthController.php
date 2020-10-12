<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanySpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(Request $request){

//       Jeśli nie zalogowany to przekierowanie na stronę powitalną
        if (!Auth::check() && $request->path() == '/') {
            return view('welcome');
        }else if (!Auth::check() && $request->path() != '/') {
            return view('welcome');
        }
//       Jeśli zalogowany to przekierowanie na stronę powitalną użytkownika
        $user = Auth::user();
        if(Auth::check()){
           return $this->checkForPermission($user,$request);
//            return view('welcome');
        }
    }
//   Sprawdzanie uprawnień po wpisaniu ścieżki dla frontu np. "AdminRole"
    public function checkForPermission($user, $request){
        $permission = json_decode($user->role->permission);
        if(!$permission){
            return view('welcome');
        }
        $hasPermission = false;
        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if($hasPermission){
            return view('welcome');
        }
//        else{
//            return redirect('/unauthorised')->with(['msg'=>'Brak uprawnień do korzystania z tej podstrony']);
//            return view('pagenotfound')->with('msg','Brak uprawnień do korzystania z tej podstrony');
//        }
        return view('welcome');
    }
    public function login(Request $request){
        $this->validate($request,[
           'email' => 'required | email',
            'password' => 'required'
        ]);
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            return response()->json([
                'msg' => 'You are logged in',
            ]);
        }else{
            return response()->json([
                'msg' => 'Wprowadzone dane nie są poprawne',
            ],401);
        }

    }
    public function logout(){
        Auth::logout();
        return view('welcome');
    }
    public function registerUser(Request $request){
        $this->validate($request,[
            'name'=> 'required',
            'email' => 'required | email',
            'password' => 'required',
        ]);
        return User::create([
            'name' => $request->name,
            'surname' =>$request->surname,
            'email' =>$request->email,
            'phone' => $request->phone,
            'password' =>bcrypt($request->password),
             'role_id' => '2',
        ]);

    }
    public function registerOwner(Request $request){
        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role_id' => '3',
            ]);
            $user = User::where('email', $request->email)->first();
            \Log::info($user);
            Company::create([
                'user_id' => $user->id,
                'name' => $request->companyName,
                'NIP' => $request->NIP,
                'location' => $request->location,
                'city' => $request->city,
                'street' => $request->street,
                'zipCode' => $request->zipCode,
                'phones' => $request->companyConvertedPhones,
            ]);
            $company = Company::where('NIP', $request->NIP)->first();
            $specs = $request->selectedSpecs;
            $companyspecs=[];
            foreach ($specs as $s) {
                array_push($companyspecs,['company_id'=>$company->id,'specialization_id'=>$s]);
                \Log::info($companyspecs);
            }
            CompanySpecialization::insert($companyspecs);
            DB::commit();
            return 'done';
        }catch (\Throwable $th){
            DB::rollback();
            return 'not done';
        }
    }
    public function unauthorised(){
        return view('pagenotfound');
    }
}
