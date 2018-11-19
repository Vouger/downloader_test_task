@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="POST" action="{{ route('add_url') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2">
                        <h2>
                            URL:
                        </h2>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="url" class="form-control"/>
                        @if($url_error)
                        <small class="form-text text-muted alert alert-danger">URL is invalid!</small>
                        @endif
                        @if($success)
                        <small class="form-text text-muted alert alert-success">URL is added to downloader queue!</small>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            Add url to queue
                        </button>
                    </div>
                </div>
            </form>
            <div id="downloader-table-wrapper">
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        function loadTable() {
            $('#downloader-table-wrapper').load("{{route('load_table')}}");
        }
        
        loadTable();
        setInterval(function () {
            loadTable()
        }, 5000);
        
        
        setTimeout(function () {
            $('.alert').fadeOut("slow")
        }, 1500);
    });
</script>
@endsection
