<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }


    public function create()
    {
        return view('patients.create');
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
            'name.required' => 'el nombre del paciente es obligatorio',
            'name.min' => 'el nombre del paciente debe tener mas de 3 caracteres',
            'email.required' => 'el correo electronico es obligatorio',
            'email.email' => 'ingresa un correo electronico valido',
            'cedula.required' => 'la cedula es obligatorio',
            'cedula.digits' => 'la cedula debe tener al menos 5 digitos',
            'name.required' => 'el nombre del paciente es obligatorio',
            'address.min' => 'la direccion debe tener al menos de 5 caracteres',
            'phone.required' => 'el numero de telefono es obligatorio',
        ];
        $this->validate($request, $rules, $messages);
        User::create(
            $request->only('name','email','cedula','address','phone')
            + [
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $notification = 'El paciente se ha registrado correctamente';
        return redirect('/pacientes')->with(compact('notification'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $patient = User::patients()->findorfail($id);
        return view('patients.edit', compact('patient'));
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
            'name.required' => 'el nombre del paciente es obligatorio',
            'name.min' => 'el nombre del paciente debe tener mas de 3 caracteres',
            'email.required' => 'el correo electronico es obligatorio',
            'email.email' => 'ingresa un correo electronico valido',
            'cedula.required' => 'la cedula es obligatorio',
            'cedula.digits' => 'la cedula debe tener al menos 5 digitos',
            'name.required' => 'el nombre del paciente es obligatorio',
            'address.min' => 'la direccion debe tener al menos de 5 caracteres',
            'phone.required' => 'el numero de telefono es obligatorio',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::patients()->findorfail($id);
        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');
        if($password)
            $data['password'] = bcrypt($password);
        $user->fill($data);
        $user->save();
        $notification = 'El paciente se ha actualizado correctamente';
        return redirect('/pacientes')->with(compact('notification'));
    }

    public function destroy($id)
    {
        $user = User::patients()->findOrFail($id);
        $patientName = $user->name;
        $user->delete();
        $notification = "El paciente $patientName Se elimino correctamente";
        return redirect('/pacientes')->with(compact('notification'));
    }
}
