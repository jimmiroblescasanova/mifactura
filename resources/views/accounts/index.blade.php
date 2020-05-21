@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Estados de cuenta de clientes
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h2>Parámetros</h2>
                                <form action="{{ route('account.excel')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="fecha_inicial" class="sr-only">Fecha Inicial:</label>
                                        <input type="text" class="form-control" name="fecha_inicial" id="fecha_inicial" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_final" class="sr-only">Fecha Inicial:</label>
                                        <input type="text" class="form-control" name="fecha_final" id="fecha_final" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-block" id="SendForm">
                                            <i class="fas fa-search"></i> Vista previa
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block" id="GetXls">
                                            <i class="fas fa-download"></i> Excel
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <h2>Resumen de estado de cuenta</h2>
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th scope="col">Saldo Anterior:</th>
                                        <td id="edc_total"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Cargos:</th>
                                        <td id="edc_cargos"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Abonos:</th>
                                        <td id="edc_abonos"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Saldo Final:</th>
                                        <td id="edc_final"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Movimientos del periodo
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Serie</th>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Importe</th>
                            </tr>
                            </thead>
                            <tbody id="reporte">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.es-es.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.25.3/locale/es.min.js"></script>
    <script>
        moment.locale();
        const SendForm = $('#SendForm');
        const reporte = $('#reporte');
        // const today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#fecha_inicial').datepicker({
            locale: 'es-es',
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            // minDate: today,
            maxDate: function () {
                return $('#fecha_final').val();
            }
        });
        $('#fecha_final').datepicker({
            locale: 'es-es',
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#fecha_inicial').val();
            }
        });

        SendForm.on('click', function (e) {
            const token = $('meta[name="csrf-token"]').attr('content');
            const route = "{{ route('account.reporte') }}";

            e.preventDefault();

            if($('input[name=fecha_inicial]').checkEmpty() && $('input[name=fecha_final]').checkEmpty())
            {
                SendForm.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...');
            reporte.html('');

            $.ajax({
                type: 'POST',
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                data: {
                    FechaInicial: $('input[name=fecha_inicial]').val(),
                    FechaFinal: $('input[name=fecha_final]').val(),
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response.documents);

                    let saldo_final = (response.saldo_inicial + response.cargos) - response.abonos;

                    $('#edc_total').html(addCommas(response.saldo_inicial));
                    $('#edc_cargos').html(addCommas(response.cargos));
                    $('#edc_abonos').html(addCommas(response.abonos));
                    $('#edc_final').html(addCommas(saldo_final));

                    $.each(response.documents, function (key, val) {
                        // console.log(moment(val.CFECHA).format('L'));
                        let table = '<tr><td>' + val.CSERIEDOCUMENTO + '</td>';
                        table += '<td>' + val.CFOLIO + '</td>';
                        table += '<td>' + moment(val.CFECHA).format('L') + '</td>';
                        table += '<td>' + val.concepto.CNOMBRECONCEPTO + '</td>';
                        if(val.CIDDOCUMENTODE != 4)
                        {
                            table += '<td class="text-right" style="color:red;"> -' + addCommas(val.CTOTAL) + '</td>';
                        } else {
                            table += '<td class="text-right">' + addCommas(val.CTOTAL) + '</td>';
                        }
                        table += '</tr>';
                        reporte.append(table);
                    });
                    SendForm.html('<i class="fas fa-search"></i> Vista previa');
                },
                error: function (response) {
                    console.log('Error: ' + response);
                },
            });
            }
        });

        (function($){
            $.fn.checkEmpty = function() {
                let isEmpty = true;
                if (this.val().length === 0)
                {
                    alert('La fecha no puede estar vacía');
                    isEmpty = false;
                }
                return isEmpty;
            };
        }(jQuery));

        function addCommas(number)
        {
            let nStr = Number(number).toFixed(2);

            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
@stop
