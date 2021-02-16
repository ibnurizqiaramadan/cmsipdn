@extends('admin/layouts/app', ['title' => 'Pengguna', 'menu' => 'users'])

@section('content')
<div class="container-fluid pb-3">
	<div class="card shadow mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<div class="float-right ml-3">
					<button class="btn btn-sm btn-primary" id="btnAdd"><i class="fas fa-user-plus mr-1"> </i>
						Baru</button>
				</div>
				<table id="listUser" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<th>Username</th>
							<th>Name</th>
							<th>Level</th>
							<th>Active</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th>Username</th>
							<th>Name</th>
							<th>Level</th>
							<th>Active</th>
							<th>Aksi</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div id="floatButton"></div>
</div>
@endsection

@section('js')
<script src="{{ base_url('assets/js/page/users.js') }}"></script>
@endsection
