@extends('admin/layouts/app', [
    'title' => 'Berita', 
    'menu' => 'post',
	'subMenu' => 'news'
])

@section('content')
<div class="container-fluid pb-3">
	<div class="card shadow mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<div class="float-right ml-3">
					<button class="btn btn-sm btn-primary" id="btnAdd">
						<i class="fas fa-user-plus mr-1"> </i>Baru
					</button>
				</div>
				<table id="listNews" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<th>Judul</th>
							<th>Author</th>
							<th>Tags</th>
							<th>Active</th>
							<th>Last Update</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th>Judul</th>
							<th>Author</th>
							<th>Tags</th>
							<th>Active</th>
							<th>Last Update</th>
							<th>Aksi</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div id="floatButton"></div>
</div>

<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="formInput">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="formBody">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('js')
<script src="{{ base_url('assets/js/page/news.js') }}" defer></script>
@endsection
