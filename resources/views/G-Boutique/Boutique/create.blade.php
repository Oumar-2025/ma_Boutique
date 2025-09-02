@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Boutique</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Créer une boutique</h5>
                <a href="{{ route('boutique.index') }}" class="btn btn-outline-light btn-sm">Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('boutique.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom de l'entreprise</label>
                            <input type="text" name="nom" value="{{ old('nom') }}"
                                class="form-control @error('nom') is-invalid @enderror" id="nom" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" name="logo" value="{{ old('logo') }}" class="form-control"
                                id="logo">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="iE" class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                id="iE">
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
                            <label for="iA" class="form-label">Adresse</label>
                            <input type="text" name="adresse" value="{{ old('adresse') }}" class="form-control"
                                id="iA">
                        </div>

                        <div class="col-md-6">
                            <label for="iTb" class="form-label">Type de boutique</label>
                            <select name="type_boutique" id="iTb"
                                class="form-select @error('type_boutique') is-invalid @enderror">
                                <option value="">--Choisir--</option>
                                <option value="Alimentation" {{ old('type_boutique') == 'Alimentation' ? 'selected' : '' }}>
                                    Alimentation</option>
                                <option value="Quincaillerie"
                                    {{ old('type_boutique') == 'Quincaillerie' ? 'selected' : '' }}>Quincaillerie
                                </option>
                                <option value="Magasin" {{ old('type_boutique') == 'Magasin' ? 'selected' : '' }}>
                                    Magasin
                                </option>
                            </select>
                            @error('type_boutique')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solide fa-fw fa-save"></i>
                            <span>Enregistrer</span>
                        </button>
                        <button type="reset" class="btn btn-info" data-bs-dismiss="modal">
                            <i class="fa-solide fa-fw fa-times"></i>
                            <span>Annuler</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
