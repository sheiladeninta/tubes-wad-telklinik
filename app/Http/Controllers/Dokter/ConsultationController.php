<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::forDokter(Auth::id())
            ->with(['pasien', 'latestMessage'])
            ->withCount('unreadMessages')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dokter.consultation.index', compact('consultations'));
    }

    public function show(Consultation $consultation)
    {
        // Pastikan hanya dokter yang bertanggung jawab yang bisa akses
        if ($consultation->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        $consultation->load(['dokter', 'pasien']);
        
        $messages = ConsultationMessage::where('consultation_id', $consultation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan dari pasien sebagai dibaca
        ConsultationMessage::where('consultation_id', $consultation->id)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('dokter.consultation.show', compact('consultation', 'messages'));
    }

    public function sendMessage(Request $request, Consultation $consultation)
    {
        // Pastikan hanya dokter yang bertanggung jawab yang bisa kirim pesan
        if ($consultation->dokter_id !== Auth::id()) {
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

    public function acceptConsultation(Consultation $consultation)
    {
        if ($consultation->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        if ($consultation->status !== 'waiting') {
            return redirect()->back()->with('error', 'Konsultasi tidak dapat diterima.');
        }

        $consultation->update([
            'status' => 'active',
            'started_at' => now()
        ]);

        return redirect()->back()->with('success', 'Konsultasi telah diterima dan dimulai.');
    }

    public function completeConsultation(Request $request, Consultation $consultation)
    {
        if ($consultation->dokter_id !== Auth::id()) {
            abort(403, 'Unauthorized access to consultation.');
        }

        if ($consultation->status !== 'active') {
            return redirect()->back()->with('error', 'Konsultasi tidak dapat diselesaikan.');
        }

        $request->validate([
            'diagnosis' => 'nullable|string|max:1000',
            'prescription' => 'nullable|string|max:1000',
            'consultation_fee' => 'nullable|numeric|min:0'
        ]);

        $consultation->update([
            'status' => 'completed',
            'completed_at' => now(),
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            'consultation_fee' => $request->consultation_fee
        ]);

        return redirect()->route('dokter.consultation.index')
            ->with('success', 'Konsultasi telah diselesaikan.');
    }

    public function getMessages(Consultation $consultation)
    {
        if ($consultation->dokter_id !== Auth::id()) {
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
}