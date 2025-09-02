@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Produits (stock)</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Créer un produit</h5>
                <a href="{{ route('produit.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('produit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="iT" class="form-label">Catégorie</label>
                            <select name="categorie_id" class="form-select" id="">
                                <option value="#">--Choisir--</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}" {{ old('categorie_id') }}>{{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}"
                                class="form-control @error('nom') is-invalid @enderror" id="nom" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image">
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="iE" class="form-label">Prix d'achat</label>
                            <input type="number" step="1" min="0" value="{{ old('prix_achat') }}"
                                name="prix_achat" class="form-control" id="iE">
                        </div>
                        <div class="col-md-4">
                            <label for="iA" class="form-label">Prix de vente</label>
                            <input type="number" step="1" min="0" name="prix_vente"
                                value="{{ old('prix_vente') }}" class="form-control" id="iA">
                        </div>
                        <div class="col-md-4">
                            <label for="iB" class="form-label">Stock</label>
                            <input type="number" step="1" min="0" name="stock" value="{{ old('stock') }}"
                                class="form-control" id="iB">
                        </div>

                        {{-- <input type="hidden" name="boutique_id" value="{{ $boutique->id }}">
            <input type="hidden" name="annexe_id" value="{{ $annexe->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}"> --}}

                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-fw fa-save"></i>
                            <span>Enregistrer</span>
                        </button>
                        <button type="reset" class="btn btn-info" data-bs-dismiss="modal">
                            <i class="fa-solid fa-fw fa-times"></i>
                            <span>Annuler</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
