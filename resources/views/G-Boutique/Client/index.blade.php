@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Clients</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Liste des clients</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-table me-1"></i>Liste des clients</h4>
                <a href="{{ route('client.create') }}" class="btn btn-primary btn-sm">Ajouter</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr class="text-center">
                                <td>{{ $client->prenom }}</td>
                                <td>{{ $client->nom }}</td>
                                <td>{{ $client->telephone }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->adresse }}</td>
                                <td>
                                    <a href="{{ route('client.show', $client->id) }}" class="btn btn-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('client.edit', $client->id) }}" class="btn btn-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Bouton pour ouvrir le modal -->
                                    <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $client->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $client->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $client->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $client->id }}">
                                                        Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer le client
                                                    <strong>{{ $client->prenom }} {{ $client->nom }}</strong> ?
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>

                                                    <!-- ✅ Formulaire unique ici -->
                                                    <form action="{{ route('client.destroy', $client->id) }}"
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
                                <td colspan="6" class="text-muted text-center">Aucun client trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
