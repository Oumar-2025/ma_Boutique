@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4"><br>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Liste des produits en stock</li>
        </ol>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Produits</h5>
                <a href="{{ route('produit.create') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-plus"></i> Ajouter</a>
            </div>
            <div class="card-body px-4 py-3">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>prix_achat</th>
                            <th>prix_vente</th>
                            <th>stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produits as $produit)
                            <tr class="text-center">
                                <td><img src="{{ asset($produit->image) }}" alt="{{ $produit->nom }}" class="img-fluid"
                                style="max-width: 40px;"></td>
                                <td>{{ $produit->nom }}</td>
                                <td>{{ $produit->prix_achat }}</td>
                                <td>{{ $produit->prix_vente }}</td>
                                <td>{{ $produit->stock }}</td>
                                <td>
                                    <a href="{{ route('produit.show', $produit->id) }}" class="btn btn-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('produit.edit', $produit->id) }}" class="btn btn-link">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Bouton pour ouvrir le modal -->
                                    <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $produit->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $produit->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $produit->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $produit->id }}">
                                                        Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer le produit
                                                    <strong>{{ $produit->nom }}</strong> ?
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>

                                                    <!-- ✅ Formulaire unique ici -->
                                                    <form action="{{ route('produit.destroy', $produit->id) }}"
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
