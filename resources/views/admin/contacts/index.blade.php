@extends('layouts.admin')

@section('title', 'Messages de Contact - Administration')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Messages de Contact</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Sujet</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr>
                                <td class="fw-bold">{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone ?? 'Non renseigné' }}</td>
                                <td>{{ Str::limit($contact->subject, 50) }}</td>
                                <td>
                                    @if($contact->is_read)
                                        <span class="badge bg-success">Lu</span>
                                    @else
                                        <span class="badge bg-danger">Non lu</span>
                                    @endif
                                </td>
                                <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.contacts.show', $contact) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($contact->is_read)
                                            <form action="{{ route('admin.contacts.mark-as-unread', $contact) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Marquer non lu">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.contacts.mark-as-read', $contact) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Marquer lu">
                                                    <i class="fas fa-envelope-open"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Aucun message de contact trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($contacts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 