@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Annexes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Liste des annexes</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-table me-1"></i>Liste des annexes</h4>
                <a href="{{ route('annexe.create') }}" class="btn btn-primary btn-sm">Ajouter</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Boutiques</th>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($annexes as $annexe)
                            <tr class="text-center">
                                <td>{{ $annexe->boutique?->nom ?? '—' }}</td>
                                <td>{{ $annexe->nom }}</td>
                                <td>{{ $annexe->telephone }}</td>
                                <td>{{ $annexe->email }}</td>
                                <td>{{ $annexe->adresse }}</td>
                                <td>
                                    <a href="{{ route('annexe.show', $annexe->id) }}" class="btn btn-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('annexe.edit', $annexe->id) }}" class="btn btn-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Bouton pour ouvrir le modal -->
                                    <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $annexe->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $annexe->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $annexe->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $annexe->id }}">
                                                        Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer l’annexe
                                                    <strong>{{ $annexe->nom }}</strong> ?
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>

                                                    <!-- ✅ Formulaire unique ici -->
                                                    <form action="{{ route('annexe.destroy', $annexe->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted text-center">Aucune annexe trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
