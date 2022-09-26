<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{

    public function index(){
        $specialties = Specialty::all();
        return view('specialties.index', compact('specialties'));
    }
    public function create(){
        return view('specialties.create');
    }
    public function sendData(Request $request){
        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'el nombre debe ser de mas de 3 caracteres'
        ];
        $this->validate($request, $rules, $messages);

        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'la especialidad se ha creado correctamente';
        return redirect('/especialidades')->with(compact('notification'));

    }
    public function edit(Specialty $specialty){
        return view('specialties.edit', compact('specialty'));
    }
    public function update(Request $request, Specialty $specialty){

        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'el nombre debe ser 3 caracteres'
        ];
        $this->validate($request, $rules, $messages);


        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'la especialidad se ha actualizado correctamente';
        return redirect('/especialidades')->with(compact('notification'));
        return redirect('/especialidades');
    }
    public function destroy(Specialty $specialty){
        $deleteName = $specialty->name;
        $specialty->delete();
        $notification = 'La especialidad '.$deleteName.' se ha Eliminado Correctamente';
        return redirect('/especialidades')->with(compact('notification'));

    }
}
