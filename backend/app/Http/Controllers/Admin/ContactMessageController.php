<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Admin/ContactMessages/Index', [
            'messages' => $messages,
            'unreadCount' => ContactMessage::unread()->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewing
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return Inertia::render('Admin/ContactMessages/Show', [
            'message' => $contactMessage,
        ]);
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => true]);

        return back()->with('success', 'Message marked as read.');
    }

    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['is_read' => false]);

        return back()->with('success', 'Message marked as unread.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
