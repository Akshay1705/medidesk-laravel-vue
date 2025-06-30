<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query()
            ->where('is_done', false)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time');

        // Apply search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter for today
        if ($request->boolean('today')) {
            $query->whereDate('appointment_date', now()->toDateString());
        }

        $appointments = $query->paginate(5)->withQueryString();

        return Inertia::render('AppointmentList', compact('appointments'));
    }


    public function completed()
    {
        $appointments = Appointment::where('is_done', true)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return Inertia::render('CompletedList', [
            'appointments' => $appointments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|size:10',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        $appointmentDate = $validated['appointment_date'];
        $appointmentTime = Carbon::createFromFormat('H:i', $validated['appointment_time']);

        $startWindow = $appointmentTime->copy()->subMinutes(29);
        $endWindow = $appointmentTime->copy()->addMinutes(29);

        $conflict = Appointment::where('appointment_date', $appointmentDate)
            ->where('is_done', false)
            ->whereBetween('appointment_time', [
                $startWindow->format('H:i'),
                $endWindow->format('H:i'),
            ])
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'appointment_time' => 'Another appointment exists in this 30-minute slot.',
            ])->withInput();
        }

        Appointment::create([
            ...$validated,
            'is_done' => false,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment added!');
    }

    public function markComplete(Appointment $appointment)
    {
        $appointment->is_done = true;
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment marked as completed.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled.');
    }
}
