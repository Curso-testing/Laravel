@extends('base')

@section('body')
    @if ($isLockedDown)
        @include('main._lockDownAlert') {{-- Asume que has convertido también el archivo _lockDownAlert.html.twig a Blade --}}
    @endif
    <div class="container volcano mt-4" style="flex-grow: 1;">
        <h1 class="mt-5">Dinotopia Status</h1>
        <div class="dino-stats-container mt-2 p-3">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Genus</th>
                    <th>Size</th>
                    <th>Enclosure</th>
                    <th>Accepting Visitors</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($dinos as $dino)
                    <tr>
                        <td>{{ $dino->name }}</td>
                        <td>{{ $dino->genus }}</td>
                        <td>{{ $dino->sizeDescription() }}</td>
                        <td>{{ $dino->enclosure }}</td>
                        <td>{{ $dino->isAcceptingVisitors() ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
