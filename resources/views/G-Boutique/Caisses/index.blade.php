@extends('../G-Boutique/layouts')
@section('contenu')
<div class="container-fluid">
    <h1 class="mb-4">Mouvements de Caisse</h1>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('caisses.index') }}" class="row mb-4">
        <div class="col-md-2">
            <label for="type"></label>
            <select name="type" class="form-select">
                <option value="">-- Type --</option>
                <option value="entrée" {{ request('type')=='entrée'?'selected':'' }}>Entrée</option>
                <option value="sortie" {{ request('type')=='sortie'?'selected':'' }}>Sortie</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="source"></label>
            <select name="source" class="form-select">
                <option value="">-- Source --</option>
                <option value="vente" {{ request('source')=='vente'?'selected':'' }}>Vente</option>
                <option value="achat" {{ request('source')=='achat'?'selected':'' }}>Achat</option>
                <option value="salaire" {{ request('source')=='salaire'?'selected':'' }}>Salaire</option>
                <option value="depense" {{ request('source')=='depense'?'selected':'' }}>Dépense</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="date_debut">Date Début</label>
            <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
        </div>
        <div class="col-md-2">
            <label for="date_fin">Date Fin</label>
            <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
        </div>

        <div class="col-md-2">
            <label for=""></label>
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
        <div class="col-md-2">
            <label for=""></label>
            <a href="{{ route('caisses.index') }}" class="btn btn-secondary w-100">Réinitialiser</a>
        </div>
    </form>

    {{-- Résumé --}}
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between">
            <span><strong>Total Entrées :</strong> {{ number_format($total_entrees, 0, ',', ' ') }} FCFA</span>
            <span><strong>Total Sorties :</strong> {{ number_format($total_sorties, 0, ',', ' ') }} FCFA</span>
            <span><strong>Solde :</strong> {{ number_format($solde, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>
    {{-- Tableau --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Source</th>
                        <th>Description</th>
                        <th>Boutique</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($caisses as $caisse)
                        <tr>
                            <td>{{ $caisse->date_mouvement }}</td>
                            <td>
                                <span class="badge bg-{{ $caisse->type=='entrée'?'success':'danger' }}">
                                    {{ ucfirst($caisse->type) }}
                                </span>
                            </td>
                            <td>{{ number_format($caisse->montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ ucfirst($caisse->source) }}</td>
                            <td>{{ $caisse->description }}</td>
                            <td>{{ $caisse->boutique->nom ?? '-' }}</td>
                            <td>{{ $caisse->user->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('caisses.show', $caisse->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('caisses.destroy', $caisse->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                                <!-- Modal de confirmation -->
                                {{-- <div class="modal fade" id="confirmDeleteModal{{ $caisse->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmer la suppression</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer ce mouvement de caisse ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="button" class="btn btn-danger" id="deleteButton{{ $caisse->id }}">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('deleteButton{{ $caisse->id }}').addEventListener('click', function() {
                                        this.closest('form').submit();
                                    });
                                </script> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun mouvement trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $caisses->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
