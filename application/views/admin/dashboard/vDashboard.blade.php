@extends('admin/layouts/app', [
    'title' => 'Dashboard', 
    'menu' => 'dashboard',
    'roti' => [
		'Home:blank' => base_url(), 
		'Dashboard:active' => '', 
	]
])

@section('content')
    <div class="container">
        <h1>Hello</h1>
    </div>
@endsection

@section('js')
    
@endsection
