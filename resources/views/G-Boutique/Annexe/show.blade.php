@extends('../G-Boutique/layouts')
@section('contenu')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Annexes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Détails de l'annexe : {{ $annexe->nom }}</li>
        </ol>
        <table class="table">
                <tr>
                    <tr>
                        <th>Boutiques</th>
                        <td>{{ $annexe->boutique->nom }}</td>
                    </tr>
                    <tr>
                        <th>Nom annexe :</th>
                        <td>{{ $annexe->nom }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $annexe->email }}</td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td>{{ $annexe->telephone }}</td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $annexe->adresse }}</td>
                    </tr>
            </table>
                                <a href="{{ route('boutique.index') }}" class="btn btn-info btn-sm">Retour</a>
        </div>
    </div>

@endsection
