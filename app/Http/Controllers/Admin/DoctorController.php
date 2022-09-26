<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;
use App\Http\Controllers\Controller;


class DoctorController extends Controller
{

    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }


    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|min:5',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'el nombre del medico es obligatorio',
            'name.min' => 'el nombre del medico debe tener mas de 3 caracteres',
            'email.required' => 'el correo electronico es obligatorio',
            'email.email' => 'ingresa un correo electronico valido',
            'cedula.required' => 'la cedula es obligatorio',
            'cedula.digits' => 'la cedula debe tener al menos 5 digitos',
            'name.required' => 'el nombre del medico es obligatorio',
            'address.min' => 'la direccion debe tener al menos de 5 caracteres',
            'phone.required' => 'el numero de telefono es obligatorio',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::create(
            $request->only('name','email','cedula','address','phone')
            + [
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $user->specialties()->attach($request->input('specialties'));
        $notification = 'El medico se ha registrado correctamente';
        return redirect('/medicos')->with(compact('notification'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $doctor = User::doctors()->findorfail($id);
        $specialties = Specialty::all();
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit', compact('doctor', 'specialties', 'specialty_ids'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|min:5',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'el nombre del medico es obligatorio',
            'name.min' => 'el nombre del medico debe tener mas de 3 caracteres',
            'email.required' => 'el correo electronico es obligatorio',
            'email.email' => 'ingresa un correo electronico valido',
            'cedula.required' => 'la cedula es obligatorio',
            'cedula.digits' => 'la cedula debe tener al menos 5 digitos',
            'name.required' => 'el nombre del medico es obligatorio',
            'address.min' => 'la direccion debe tener al menos de 5 caracteres',
            'phone.required' => 'el numero de telefono es obligatorio',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::doctors()->findorfail($id);
        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');
        if($password)
            $data['password'] = bcrypt($password);
        $user->fill($data);
        $user->save();
        $user->specialties()->sync($request->input('specialties'));
        $notification = 'El medico se ha actualizado correctamente';
        return redirect('/medicos')->with(compact('notification'));
    }

    public function destroy($id)
    {
        $user = User::doctors()->findOrFail($id);
        $doctorName = $user->name;
        $user->delete();
        $notification = "El medico $doctorName Se elimino correctamente";
        return redirect('/medicos')->with(compact('notification'));
    }
}
