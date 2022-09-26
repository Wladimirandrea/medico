<?php

namespace App\Http\Controllers;
use App\Models\Specialty;
use App\Models\Appointment;
use App\Models\CancelledAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Interfaces\HorarioServiceInterface;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index(){

        $role = auth()->user()->role;
        if($role == 'admin'){
            //admin
            $confirmedAppointments = Appointment::all()->where('status', 'Confirmada');
            $pendingAppointments = Appointment::all()->where('status', 'Reservada');
            $oldAppointments = Appointment::all()->whereIn('status', ['Atendida', 'Cancelada']);

        }elseif($role == 'doctor'){
             //doctor
            $confirmedAppointments = Appointment::all()->where('status', 'Confirmada')->where('doctor_id', auth()->id());
            $pendingAppointments = Appointment::all()->where('status', 'Reservada')->where('doctor_id', auth()->id());
            $oldAppointments = Appointment::all()->whereIn('status', ['Atendida', 'Cancelada'])->where('doctor_id', auth()->id());

        }elseif($role == 'paciente'){
             //pacientes
            $confirmedAppointments = Appointment::all()->where('status', 'Confirmada')->where('patient_id', auth()->id());
            $pendingAppointments = Appointment::all()->where('status', 'Reservada')->where('patient_id', auth()->id());
            $oldAppointments = Appointment::all()->whereIn('status', ['Atendida', 'Cancelada'])->where('patient_id', auth()->id());

        }
        return view('appointments.index', compact('confirmedAppointments', 'pendingAppointments', 'oldAppointments', 'role'));
    }

    public function create(HorarioServiceInterface $horarioServiceInterface){
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }
        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if($date && $doctorId){
            $intervals = $horarioServiceInterface->getAvailableIntervals($date, $doctorId);
        }else{
            $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'doctors', 'intervals'));
    }
    public function store(Request $request, HorarioServiceInterface $horarioServiceInterface){
        $rules = [
            'scheduled_time' => 'required',
            'type' => 'required',
            'description' => 'required',
            'doctor_id' => 'exists:users,id',
            'specialty_id' => 'exists:specialties,id',

        ];
        $messages = [
            'scheduled_time.required' => 'Debe seleccionar una hora valida para su cita',
            'type.required' => 'Debe seleccionar el tipo de consulta',
            'description.required' => 'Debe colocar sus sintomas'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request, $horarioServiceInterface){
            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $scheduled_time = $request->input('scheduled_time');
            if($date && $doctorId && $scheduled_time){
                $start = new Carbon($scheduled_time);
            }else {
                return;
            }
            if (!$horarioServiceInterface->isAvailableInterval($date,$doctorId,$start)) {
                $validator->errors()->add(
                    'available_time', 'La hora seleccionada se encuentra reservada!'
                );
            }
        });

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->only([
            'scheduled_date',
            'scheduled_time',
            'type',
            'description',
            'doctor_id',
            'specialty_id',
        ]);
        $data['patient_id'] = auth()->id();
        $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');
        Appointment::create($data);
        $notification = 'la cita se ha relizado correctamente';
        return back()->with(compact('notification'));
    }

    public function cancel(Appointment $appointment, Request $request){
        if($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();
            $appointment->cancellation()->save($cancellation);
        }
        $appointment->status = 'Cancelada';
        $appointment->save();
        $notification = 'La citas se ha cancelado correctamente';
        return redirect('/miscitas')->with(compact('notification'));
    }
    public function confirm(Appointment $appointment){
        $appointment->status = 'Confirmada';
        $appointment->save();
        $notification = 'La citas se ha confirmado correctamente';
        return redirect('/miscitas')->with(compact('notification'));
    }

    public function formCancel(Appointment $appointment){
        if($appointment->status == 'Confirmada' || $appointment->status == 'Reservada'){
            $role = auth()->user()->role;
            return view('appointments.cancel', compact('appointment', 'role'));
        }
        return redirect('/miscitas');

    }
    public function show(Appointment $appointment){
        $role = auth()->user()->role;
        return view('appointments.show', compact('appointment', 'role'));
    }
}
