@extends('admin/layouts/app', [
	'title' => 'Berita',
	'menu' => 'post',
	'subMenu' => 'news', 
	'roti' => [
		'Home:blank' => base_url(), 
		'Dashboard' => base_url(ADMIN_PATH . '/dashboard'), 
		'Post' => '', 
		'Berita:active' => '', 
	]
])

@section('content')
{{-- {{ DATE_NOW }} --}}
<div class="container-fluid pb-3">
	<div class="card shadow mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<div class="float-right ml-3">
					<button class="btn btn-sm btn-primary" id="btnAdd" title="Berita Baru">
						<i class="fas fa-user-plus mr-1"> </i>Baru
					</button>
				</div>
				<table id="listNews" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<th>Judul</th>
							<th>Pembuat</th>
							<th>Tags</th>
							<th>Terakhir diubah</th>
							<th>crated at</th>
							<th>Aktif</th>
							<th>Aksi</th>
							<th>status</th>
						</tr>
					</thead>

					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th>Judul</th>
							<th>Pembuat</th>
							<th>Tags</th>
							<th>Terakhir diubah</th>
							<th>crated at</th>
							<th>Aktif</th>
							<th>Aksi</th>
							<th>status</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div id="floatButton"></div>
</div>

<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl modal-dialog-centered" >
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
<script src="{{ base_url('/assets/modules/ckeditor/ckeditor.js') }}" defer></script>
<script src="{{ base_url('assets/js/page/news.js') }}" defer></script>
@endsection
