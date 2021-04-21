@extends('admin/layouts/app', [
    'title' => 'Dashboard', 
    'menu' => 'dashboard',
    'roti' => [
		'Home:blank' => base_url(), 
		'Dashboard:active' => '', 
	]
])

@section('content')
    <div class="container-fluid pb-3">
        <div class="row">
            <div class="col-12">
                <h1>Hello</h1>
            </div>
        </div>
    </div>
@endsection

@section('js')
    
@endsection
