@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Paiements</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Paiements</h5>
                <a href="{{ route('paiements.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('paiements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            {{-- Bénéficiaire --}}
                            <label for="prenom" class="form-label">Bénéficiaire</label>
                            <select name="employe_id" class="form-select @error('employe_id') is-invalid @enderror"
                                id="employe_id" required>
                                <option value="" disabled selected>-- Sélectionner --</option>
                                @foreach ($employes as $employe)
                                    <option value="{{ $employe->id }}" data-salaire="{{ $employe->salaire }}"
                                        {{ old('employe_id') == $employe->id ? 'selected' : '' }}>
                                        {{ $employe->prenom }} {{ $employe->nom }}</option>
                                @endforeach
                            </select>
                            @error('employe_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="montant" class="form-label">Salaire de base</label>
                            <input type="number" name="montant" id="montant" class="form-control"
                                placeholder="Montant">
                            @error('montant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="col-md-4">
                             // Type de paiement
                            <label for="iT" class="form-label">Type</label>
                            <input type="text" name="type" value="{{ old('type') }}"
                                class="form-control @error('type') is-invalid @enderror" id="iT"
                                placeholder="Entrer le type" required>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="row mb-3">
                            <!-- Mois -->
                        <div class="col-md-4">
                            <label class="form-label">Mois</label>
                            <select name="mois" class="form-select">
                                @foreach (['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $mois)
                                    <option value="{{ $mois }}" {{ old('mois') == $mois ? 'selected' : '' }}>
                                        {{ $mois }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Année -->
                        <div class="col-md-4">
                            <label class="form-label">Année</label>
                            <select name="annee" class="form-select">
                                @for ($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}" {{ old('annee', date('Y')) == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        {{-- Date de paiement --}}
                        <div class="col-md-4">
                            <label for="date_paiement" class="form-label">Date de Paiement</label>
                            <input type="date" name="date_paiement" value="{{ old('date_paiement') }}"
                                class="form-control @error('date_paiement') is-invalid @enderror" id="date_paiement"
                                required>
                            @error('date_paiement')
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
    <script>
        document.getElementById('employe_id').addEventListener('change', function() {
            const salaire = this.selectedOptions[0].dataset.salaire;
            document.getElementById('montant').value = salaire;
        });
    </script>
@endsection
