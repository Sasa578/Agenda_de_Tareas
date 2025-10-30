<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('notificaciones.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }

    public function destroy($id)
    {
        Auth::user()->notifications()->where('id', $id)->delete();
        
        return redirect()->back()->with('success', 'Notificación eliminada.');
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        
        return redirect()->back()->with('success', 'Todas las notificaciones eliminadas.');
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        
        return response()->json(['count' => $count]);
    }

    public function getNotifications()
    {
        $notifications = Auth::user()->unreadNotifications()->take(5)->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'titulo' => $notification->data['titulo'] ?? 'Notificación',
                'mensaje' => $notification->data['mensaje'] ?? '',
                'url' => $notification->data['url'] ?? '#',
                'time' => $notification->created_at->diffForHumans(),
                'type' => $notification->data['tipo'] ?? 'info'
            ];
        });

        return response()->json($notifications);
    }
}