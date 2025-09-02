@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Fournisseur</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Créer un Fournisseur</h5>
                <a href="{{ route('fournisseur.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('fournisseur.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}"
                                class="form-control @error('nom') is-invalid @enderror" id="nom" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="col-md-6">
                            <label for="iT" class="form-label">Telephone</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}"
                                class="form-control @error('telephone') is-invalid @enderror" id="iT">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="iE" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control"
                                id="iE">
                        </div>
                        <div class="col-md-6">
                            <label for="iA" class="form-label">Adresse</label>
                            <input type="text" name="adresse" value="{{ old('adresse') }}" class="form-control"
                                id="iA">
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
