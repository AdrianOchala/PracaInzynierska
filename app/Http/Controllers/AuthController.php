<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanySpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
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
//           return $this->checkForPermission($user,$request);
            return view('welcome');
        }
    }
//   Sprawdzanie uprawnień po wpisaniu ścieżki dla frontu np. "AdminRole"
    public function checkForPermission($user, $request){
        $permission = json_decode($user->role->permission);
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
        }else{
            return redirect('/unauthorised')->with(['msg'=>'Brak uprawnień do korzystania z tej podstrony']);
//            return view('pagenotfound')->with('msg','Brak uprawnień do korzystania z tej podstrony');
        }
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
        User::create([
           'name' => $request->name,
            'surname' =>$request->surname,
            'email' =>$request->email,
            'phone' => $request->phone,
            'password' =>bcrypt($request->password),
            'role_id' => '3',
        ]);
        $user = User::where('email',$request->email)->first();

        Company::create([
            'owner_id' => $user->id,
            'name' => $request->companyName,
            'NIP' => $request->NIP,
            'location' => $request->location,
            'city' => $request->city,
            'street' => $request->street,
            'zip-code' => $request->zipCode,
            'phones' => $request->companyConvertedPhones,
        ]);
        $company = Company::where('NIP', $request->NIP)->first();
        $specs = $request->selectedSpecs;
        foreach ($specs as $s){
            CompanySpec::create([
                'company_id' => $company->id,
                'specialization_id' => $s
            ]);
        }
        return 'done';
    }
    public function unauthorised(){
        return view('pagenotfound');
    }
}
