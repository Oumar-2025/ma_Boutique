@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">employé</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails de l'employé Poste: {{ $employe->poste }}</h5>
                <a href="{{ route('employes.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i> Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                    <tr>
                        <th>Prénom :</th>
                        <td>{{ $employe->prenom }}</td>
                    </tr>
                    <tr>
                        <th>Nom :</th>
                        <td>{{ $employe->nom }}</td>
                    </tr>
                    <tr>
                        <th>Email :</th>
                        <td>{{ $employe->email }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone :</th>
                        <td>{{ $employe->telephone }}</td>
                    </tr>
                    <tr>
                        <th>Salaire :</th>
                        <td>{{ $employe->salaire }}</td>
                    </tr>
                    <tr>
                        <th>Poste :</th>
                        <td>{{ $employe->poste }}</td>
                    </tr>
                    <tr>
                        <th>Nom urgence :</th>
                        <td>{{ $employe->nomurg }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone urgence :</th>
                        <td>{{ $employe->telurg }}</td>
                    </tr>
                    <tr>
                        <th>Relation urgence :</th>
                        <td>{{ $employe->relation }}</td>
                    </tr>

                </table>
            </div>
        </div>
    @endsection
