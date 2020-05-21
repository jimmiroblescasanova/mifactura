@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <p>AJAX</p>
                    
                     <div id="table-body"></div>     
                </div>
                <div class="card-footer pb-0">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                          <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" id="next-page" href="">Next</a>
                          </li>
                        </ul>
                      </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script>
    const token = $('meta[name="csrf-token"]').attr('content');
    let route = $('#next-page').attr('href');

    $.ajax({
        type: 'GET',
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'html',
        success: function (response) {
            // $('#next-page').attr('href', response.next_page_url);
            console.log(response);
            $('#table-body').html(response);
            
        },
        error: function (response) {
            console.log('Error: ' + response);
        },
    });
</script>
@stop