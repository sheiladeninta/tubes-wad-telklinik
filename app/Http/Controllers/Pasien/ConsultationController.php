<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::forPasien(Auth::id())
            ->with(['dokter', 'latestMessage'])
            ->withCount('unreadMessages')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pasien.consultation.index', compact('consultations'));
    }

    public function create()
    {
        $availableDoctors = User::dokter()
            ->where('is_active', true)
            ->select('id', 'name', 'specialist')
            ->get();

        return view('pasien.consultation.create', compact('availableDoctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'priority' => ['required', Rule::in(['low', 'normal', 'high', 'urgent'])],
            'dokter_id' => 'nullable|exists:users,id'
        ]);

        $consultation = Consultation::create([
            'pasien_id' => Auth::id(),
            'dokter_id' => $request->dokter_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'waiting'
        ]);

        // Buat pesan pertama dengan deskripsi keluhan
        ConsultationMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'message' => $request->description,
            'message_type' => 'text'
        ]);

        return redirect()->route('pasien.consultation.show', $consultation->id)
            ->with('success', 'Konsultasi berhasil dibuat. Menunggu dokter untuk merespons.');
    }

    public function show(Consultation $consultation)
    {
        // Pastikan hanya pasien yang memiliki konsultasi ini yang bisa akses
        if ($consultation->pasien_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        $consultation->load(['dokter', 'pasien']);
        
        $messages = ConsultationMessage::where('consultation_id', $consultation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan dari dokter sebagai dibaca
        ConsultationMessage::where('consultation_id', $consultation->id)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('pasien.consultation.show', compact('consultation', 'messages'));
    }

    public function sendMessage(Request $request, Consultation $consultation)
    {
        // Pastikan hanya pasien yang memiliki konsultasi ini yang bisa kirim pesan
        if ($consultation->pasien_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        $request->validate([
            'message' => 'required_without:attachment|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120' // 5MB max
        ]);

        $messageData = [
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message ?? '',
            'message_type' => 'text'
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('consultation-attachments', $filename, 'public');
            
            $messageData['attachment'] = $path;
            $messageData['message_type'] = in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']) ? 'image' : 'file';
            
            if (empty($messageData['message'])) {
                $messageData['message'] = 'File: ' . $file->getClientOriginalName();
            }
        }

        $message = ConsultationMessage::create($messageData);

        // Update status konsultasi jika masih waiting
        if ($consultation->status === 'waiting') {
            $consultation->update(['status' => 'active', 'started_at' => now()]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
                'consultation_status' => $consultation->fresh()->status
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function endConsultation(Consultation $consultation)
    {
        // Pastikan hanya pasien yang memiliki konsultasi ini yang bisa mengakhiri
        if ($consultation->pasien_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        if (!in_array($consultation->status, ['active', 'waiting'])) {
            return redirect()->back()->with('error', 'Konsultasi tidak dapat diakhiri.');
        }

        $consultation->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        return redirect()->route('pasien.consultation.index')
            ->with('success', 'Konsultasi telah diakhiri. Terima kasih telah menggunakan layanan kami.');
    }

    public function getMessages(Consultation $consultation)
    {
        // Pastikan hanya pasien yang memiliki konsultasi ini yang bisa akses
        if ($consultation->pasien_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        $messages = ConsultationMessage::where('consultation_id', $consultation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'consultation_status' => $consultation->status
        ]);
    }

    public function cancel(Consultation $consultation)
    {
        // Pastikan hanya pasien yang memiliki konsultasi ini yang bisa membatalkan
        if ($consultation->pasien_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        if (!in_array($consultation->status, ['waiting', 'active'])) {
            return redirect()->back()->with('error', 'Konsultasi tidak dapat dibatalkan.');
        }

        $consultation->update(['status' => 'cancelled']);

        return redirect()->route('pasien.consultation.index')
            ->with('success', 'Konsultasi berhasil dibatalkan.');
    }
}