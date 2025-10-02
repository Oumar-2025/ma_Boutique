@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Employés</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Créer un employé</h5>
                <a href="{{ route('employes.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('employes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}"
                                class="form-control @error('prenom') is-invalid @enderror" id="prenom" placeholder="Entrez le prénom" required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}"
                                class="form-control @error('nom') is-invalid @enderror" id="nom" placeholder="Entrez le nom" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iT" class="form-label">Telephone</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}"
                                class="form-control @error('telephone') is-invalid @enderror" id="iT" placeholder="Entrez le téléphone" required>
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="iE" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email"
                                class="form-control @error('email') is-invalid @enderror" id="iE" placeholder="Entrez l'email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iA" class="form-label">Poste</label>
                            <input type="text" name="poste" value="{{ old('poste') }}"
                                class="form-control @error('poste') is-invalid @enderror" id="iA" placeholder="Entrez le poste" required>
                            @error('poste')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iS" class="form-label">Salaire</label>
                            <input type="number" step="1" min="0" name="salaire" value="{{ old('salaire') }}"
                                class="form-control @error('salaire') is-invalid @enderror" id="iS" placeholder="Entrez le salaire" required>
                            @error('salaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="iNU" class="form-label">Nom Urgence</label>
                            <input type="text" value="{{ old('nomurg') }}" name="nomurg"
                                class="form-control @error('nomurg') is-invalid @enderror" id="iNU" placeholder="Entrez le nom d'urgence">
                            @error('nomurg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iTU" class="form-label">Tel Urgence</label>
                            <input type="text" value="{{ old('telurg') }}" name="telurg"
                                class="form-control @error('telurg') is-invalid @enderror" id="iTU" placeholder="Entrez le téléphone d'urgence">
                            @error('telurg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="iR" class="form-label">Relation</label>
                            <select name="relation" id="iR"
                                class="form-select @error('relation') is-invalid @enderror">
                                <option value="" disabled selected>-- Sélectionner --</option>
                                <option value="Parent" {{ old('relation') == 'Parent' ? 'selected' : '' }}>Parent</option>
                                <option value="Oncle" {{ old('relation') == 'Oncle' ? 'selected' : '' }}>Oncle</option>
                                <option value="Tante" {{ old('relation') == 'Tante' ? 'selected' : '' }}>Tante</option>
                                <option value="Ami(e)" {{ old('relation') == 'Ami(e)' ? 'selected' : '' }}>Ami(e)</option>
                                <option value="Autre" {{ old('relation') == 'Autre' ? 'selected' : '' }}>Autre</option>

                            </select>
                            @error('relation')
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
        @endsection
