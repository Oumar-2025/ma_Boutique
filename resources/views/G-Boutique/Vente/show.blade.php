@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Produit</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails de la vente du : {{ $vente->date_vente }}</h5>
                <a href="{{ route('ventes.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">

                <h3>Nom du client :</h3>
                <p>{{ $vente->client->prenom }} {{ $vente->client->nom }}</p>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vente->details as $detail)
                            <tr>
                                <td>{{ $detail->produit->nom }}</td>
                                <td>{{ $detail->quantite }}</td>
                                <td>{{ $detail->prix_unitaire }}</td>
                                <td>
                                    <!-- Bouton Modifier -->
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editDetailModal{{ $detail->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Bouton de suppression -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteDetailModal{{ $detail->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editDetailModal{{ $detail->id }}" tabindex="-1"
                                        aria-labelledby="editDetailLabel{{ $detail->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form
                                                action="{{ route('detail-vente.update',  $detail->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title" id="editDetailLabel{{ $detail->id }}">
                                                            Modifier {{ $detail->produit->nom }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label"
                                                            class="form-label"><span style="color: red">Stock disponible :</span> {{ $detail->produit->stock }}</label>
                                                            <hr>
                                                        <label for="quantite{{ $detail->id }}"
                                                            class="form-label">Quantité :</label>
                                                        <input type="number" min="1" class="form-control"
                                                            name="quantite" id="quantite{{ $detail->id }}"
                                                            value="{{ $detail->quantite }}" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteDetailModal{{ $detail->id }}" tabindex="-1"
                                        aria-labelledby="deleteDetailLabel{{ $detail->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form
                                                action="{{ route('detail-vente.delete',  $detail->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteDetailLabel{{ $detail->id }}">
                                                            Supprimer {{ $detail->produit->nom }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Êtes-vous sûr de vouloir supprimer {{ $detail->produit->nom }} ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucun détail de vente trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>
    @endsection
