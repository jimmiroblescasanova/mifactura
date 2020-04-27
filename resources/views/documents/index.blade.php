@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <form action="{{ route('documents.invoice.selected') }}" method="post" id="selectedRows">
                        <div class="card-header d-flex justify-content-between">
                            <span>Todas mis facturas</span>
                            <button class="btn btn-primary btn-sm" type="submit">Descargar seleccionados</button>
                        </div>
                        @csrf
                        <div class="card-body table-responsive">
                            <div id="alert"></div>

                            <table class="table table-striped table-hover" id="invoices" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Serie</th>
                                    <th>Folio</th>
                                    <th>UUID</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($documentos as $docto)
                                    <tr>
                                        <td>{{ $docto->Folio }}</td>
                                        <td>{{ $docto->Fecha->format('Y-m-d') }}</td>
                                        <td>{{ $docto->Serie }}</td>
                                        <td>{{ $docto->Folio }}</td>
                                        <td>{{ $docto->UUID }}</td>
                                        <td class="text-right">$ {{ convertir_a_numero($docto->Total) }}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-primary btn-sm getXML" data-guid="{{ $docto->GuidDocument }}">XML</button>
                                            <button type="button" class="btn btn-danger btn-sm getPDF" data-guid="{{ $docto->GuidDocument }}">PDF</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No hay registros.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.getXML').on('click', function (e) {
                e.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const route = "{{ route('documents.download.xml') }}";

                const alert = $('#alert');
                const btn = $(this);
                const GuidDocument = btn.data('guid');

                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espera...');

                $.ajax({
                    type: 'POST',
                    url: route,
                    headers: { 'X-CSRF-TOKEN': token },
                    data: {
                        GuidDocument: GuidDocument,
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);

                        btn.html('XML');
                        alert.html('<div class="alert alert-success" role="alert">Tu archivo esta listo para descargar: <a href="{{ url('documents/download') }}/'+ response.filename +'">'+ response.filename +'</a></div>');
                    },
                    error: function (response) {
                        console.log('Error: '+response);
                    },
                });
            });

            $('.getPDF').on('click', function (e) {
                e.preventDefault();

                const alert = $('#alert');

                const btn = $(this);
                const GuidDocument = btn.data('guid');

                const token = $('meta[name="csrf-token"]').attr('content');
                const route = "{{ route('documents.download.pdf') }}";

                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espera...');

                $.ajax({
                    type: 'POST',
                    url: route,
                    headers: { 'X-CSRF-TOKEN': token },
                    data: {
                        GuidDocument: GuidDocument,
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response[0].FileName);

                        btn.html('PDF');
                        alert.html('<div class="alert alert-success" role="alert">Tu archivo esta listo para descargar: '+ response[0].FileName +'</div>');
                    },
                    error: function (response) {
                        console.log('Error: '+response);
                    },
                });
            });

            const table = $('#invoices').DataTable({
                'language': {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                'info': false,
                'columnDefs': [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    }
                ],
                'select': {
                    'style': 'multi'
                },
                'order': [
                    [1, 'asc']
                ],
            });

            $('#selectedRows').on('submit', function(e) {
                const form = this;
                const rows_selected = table.column(0).checkboxes.selected();

                console.log(rows_selected.join(","));

                // Iterate over all selected checkboxes
                $.each(rows_selected, function (index, rowId) {
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'id[]')
                            .val(rowId)
                    );
                });
            });
        });
    </script>
@stop
