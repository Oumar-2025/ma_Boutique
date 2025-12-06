@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dépenses</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Créer une dépense</h5>
                <a href="{{ route('depenses.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('depenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="iC" class="form-label">Categorie</label>
                            <select name="categorie" id="iC" class="form-select @error('categorie') is-invalid @enderror">
                                <option value="" disabled selected>-- Sélectionner --</option>
                                <option value="Loyer" {{ old('categorie') == 'Loyer' ? 'selected' : '' }}>Loyer</option>
                                <option value="Entretien" {{ old('categorie') == 'Entretien' ? 'selected' : '' }}>Entretien</option>
                                <option value="Electricite" {{ old('categorie') == 'Electricite' ? 'selected' : '' }}>Electricité</option>
                                <option value="Autres" {{ old('categorie') == 'Autres' ? 'selected' : '' }}>Autres</option>
                            </select>
                            @error('categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iT" class="form-label">Montant</label>
                            <input type="number" min="0" step="1" name="montant" value="{{ old('montant') }}"
                                class="form-control @error('montant') is-invalid @enderror" placeholder="Taper le montant" id="iT">
                            @error('montant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-4">
                            <label for="iP" class="form-label">Date de depense</label>
                            <input type="date" name="date_depense" value="{{ old('date_depense') }}"
                                class="form-control @error('date_depense') is-invalid @enderror" id="iP">
                            @error('date_depense')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="libelle" class="form-label">Motif</label>
                            <textarea type="text" name="libelle"
                                class="form-control @error('libelle') is-invalid @enderror" id="libelle" placeholder="Quel est le motif de la dépense" required>{{ old('libelle') }}</textarea>
                            @error('libelle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                        {{-- <input type="hidden" name="boutique_id" value="{{ $boutique->id }}">
                            <input type="hidden" name="annexe_id" value="{{ $annexe->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}"> --}}


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
