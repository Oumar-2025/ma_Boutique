@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4"><br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Liste des achats</li>
        </ol>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Achats</h5>
                <a href="{{ route('achats.create') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-plus"></i> Ajouter</a>
            </div>
            <div class="card-body px-4 py-3">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>fournisseur</th>
                            {{-- <th>A payer</th> --}}
                            <th>Total Fcfa</th>
                            <th>Date d'achat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achats as $achat)
                            <tr class="text-center">
                                <td>{{ $achat->fournisseur->prenom }} {{ $achat->fournisseur->nom }}</td>
                                <td>{{ $achat->total }} Fcfa</td>
                                <td>{{ $achat->date_achat }}</td>
                                <td>
                                    <a href="{{ route('achats.show', $achat->id) }}" class="btn btn-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('achats.showFacture', $achat->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>

                                    <a href="{{ route('achats.edit', $achat->id) }}" class="btn btn-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Bouton pour ouvrir le modal -->
                                    <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $achat->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $achat->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $achat->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $achat->id }}">
                                                        Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer l'achat
                                                    <strong>{{ $achat->id }}</strong> ?
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>

                                                    <!-- ✅ Formulaire unique ici -->
                                                    <form action="{{ route('achats.destroy', $achat->id) }}"
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
                                <td colspan="6" class="text-muted text-center">Aucun achat trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
