<table class="table">
    <thead>
        <tr>
            <th>FECHA</th>
            <th>FOLIO</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody id="table-body">
        @foreach($usuarios as $user)
            <tr>
                <td>{{ $user->CFECHA }}</td>
                <td>{{ $user->CFOLIO }}</td>
                <td>{{ $user->CTOTAL }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
{{ $usuarios->links() }}