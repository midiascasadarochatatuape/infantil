<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlockedDate;
use App\Models\DateModification;
use App\Models\DateBlockNotification; // Adicione esta linha
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlockedDateController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = now()->startOfDay();

        // Se for admin, mostra todas as datas bloqueadas atuais e futuras
        // Se for membro, mostra apenas as próprias datas bloqueadas atuais e futuras
        $blockedDates = $user->isAdmin()
            ? BlockedDate::with('user')
                ->whereDate('blocked_date', '>=', $today)
                ->orderBy('user_id', 'desc')
                ->get()
            : BlockedDate::where('user_id', $user->id)
                ->whereDate('blocked_date', '>=', $today)
                ->orderBy('user_id', 'desc')
                ->get();

        return view('blocked-dates.index', compact('blockedDates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blocked_date' => 'required|date',
            'reason' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $blockedDate = BlockedDate::create($validated);

        // Verificar quantidade de bloqueios para a data
        $blockCount = BlockedDate::whereDate('blocked_date', $request->blocked_date)->count();

        if ($blockCount >= 6) {
            DateBlockNotification::updateOrCreate(
                ['blocked_date' => $request->blocked_date],
                [
                    'block_count' => $blockCount,
                    'notified' => false
                ]
            );

            // Criar notificação para administradores
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                DateModification::create([
                    'user_id' => $admin->id,
                    'modified_date' => $request->blocked_date,
                    'action_type' => 'multiple_blocks',
                    'read' => false,
                    'message' => $blockCount . ' usuários bloquearam a data ' . Carbon::parse($request->blocked_date)->format('d/m/Y')
                ]);
            }
        }

        return redirect()->route('blocked-dates.index')
            ->with('success', 'Data bloqueada com sucesso.');
    }

    public function destroy(BlockedDate $blockedDate)
    {
        DateModification::create([
            'user_id' => auth()->id(),
            'modified_date' => $blockedDate->blocked_date,
            'action_type' => 'removed'
        ]);

        $blockedDate->delete();
        return redirect()->route('blocked-dates.index')
            ->with('success', 'Data removida com sucesso.');
    }
}
