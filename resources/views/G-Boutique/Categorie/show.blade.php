@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Catégorie</h1>
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 style="color:white;">Détails de la catégorie : {{ $categorie->nom }}</h5>
                <a href="{{ route('categorie.index') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-list"></i>
                    Liste</a>
            </div>
            <div class="card-body px-4 py-3">
                <table class="table">
                    <tr>
                        <th>Nom :</th>
                        <td>{{ $categorie->nom }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endsection
