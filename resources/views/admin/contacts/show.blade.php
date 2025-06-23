@extends('layouts.admin')

@section('title', 'Détail du message de contact')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
    </div>
    <div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Détail du message</h1>
        <div class="mb-4">
            <span class="font-semibold">Nom :</span>
            <span>{{ $contact->name }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Email :</span>
            <span>{{ $contact->email }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Téléphone :</span>
            <span>{{ $contact->phone ?? 'Non renseigné' }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Sujet :</span>
            <span>{{ $contact->subject }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Message :</span>
            <div class="mt-2 p-4 bg-gray-50 rounded text-gray-800">{{ $contact->message }}</div>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Statut :</span>
            @if($contact->is_read)
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Lu</span>
            @else
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Non lu</span>
            @endif
        </div>
        <div class="mb-4">
            <span class="font-semibold">Reçu le :</span>
            <span>{{ $contact->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex space-x-2 mt-6">
            @if($contact->is_read)
                <form action="{{ route('admin.contacts.mark-as-unread', $contact) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Marquer non lu</button>
                </form>
            @else
                <form action="{{ route('admin.contacts.mark-as-read', $contact) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Marquer lu</button>
                </form>
            @endif
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection 