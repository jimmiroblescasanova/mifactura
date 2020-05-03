@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="card-header d-flex justify-content-between">
                            <span>Todas mis facturas</span>
                            <button class="btn btn-primary btn-sm" type="submit" id="downloadSelected">Descargar seleccionados</button>
                        </div>
                        @csrf
                        <div class="card-body table-responsive">
                            <div class="alert alert-success" role="alert" id="alert">
                                <span id="alert-text"></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <table class="table table-striped table-hover" id="invoices" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Serie</th>
                                    <th>Folio</th>
                                    <th>UUID</th>
                                    <th>Total</th>
                                    <th>Descargar</th>
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
                                            <a href="{{ route('documents.download.pdf', $docto->GuidDocument) }}" class="btn btn-danger btn-sm" target="_blank">PDF</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No hay registros.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function(){
            const alert = $('#alert');
            const alertText = $('#alert-text');
            alert.hide();

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

            $('#downloadSelected').on('click', function(e) {
                e.preventDefault();

                const btn = $(this);
                const type = $('input[name=type]').val();
                const rows_selected = table.column(0).checkboxes.selected();

                const token = $('meta[name="csrf-token"]').attr('content');
                const route = "{{ route('documents.invoice.selected') }}";
                let IdSelected = [];

                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando archivo...');

                // Iterate over all selected checkboxes
                $.each(rows_selected, function (index, rowId) {
                    IdSelected.push(rowId);
                });
                console.log(IdSelected);

                $.ajax({
                    type: 'POST',
                    url: route,
                    headers: { 'X-CSRF-TOKEN': token },
                    data: {
                        type: type,
                        id: IdSelected,
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);

                        btn.html('Descargar seleccionados');
                        alert.show();
                        alertText.html('Tu archivo esta listo para descargar: <a href="{{ url('documents/download') }}/'+ response.filename +'">'+ response.filename +'</a>');
                    },
                    error: function (response) {
                        console.log('Error: '+response);
                    },
                });
            });

            $('.getXML').on('click', function (e) {
                e.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const route = "{{ route('documents.download.xml') }}";

                const btn = $(this);
                const GuidDocument = btn.data('guid');

                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...');

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
                        alert.show();
                        alertText.html('Tu archivo esta listo para descargar: <a href="{{ url('documents/download') }}/'+ response.filename +'">'+ response.filename +'</a>');
                    },
                    error: function (response) {
                        console.log('Error: '+response);
                    },
                });
            });

        });
    </script>
@stop
