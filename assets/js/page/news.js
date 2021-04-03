CURRENT_PATH = ADMIN_PATH + "/news/";

function refreshTable() {
	table.ajax.reload(null, !1)
}

function setStatus(status, id) {
	confirmSweet("Anda yakin ingin merubah status ?").then(result => {
		if (isConfirmed(result)) {
			$.ajax({
				url: CURRENT_PATH + "set/" + id,
				data: {
					_token: TOKEN,
					status: status
				},
				type: "POST",
				dataType: "JSON",
				beforeSend: function () {
					disableButton()
				},
				complete: function () {
					enableButton()
				},
				success: function (result) {
					"ok" == result.status ? (refreshTable(), toastSuccess(result.message)) : (enableButton(), toastError(result.message, "Gagal"))
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
}

function initTable() {
	table = $("#listNews").DataTable({
		processing: !0,
		serverSide: !0,
		order: [],
		ajax: {
			url: API_PATH + "data/news",
			type: "POST",
			data: {
				_token: TOKEN
			},
			complete: function () {
				checkPilihan({
					table: "#listNews",
					buttons: ['delete', 'active', 'deactive'],
					path: CURRENT_PATH
				})
			},
			error: function (error) {
				errorCode(error)
			}
		},
		fnCreatedRow: function (nRow, aData, iDataIndex) {

		},
		columns: [{
			data: "id"
		}, {
			data: "title"
		}, {
			data: "slug"
		}, {
			data: 'cover'
		}, {
			data: "author"
		}, {
			data: "category"
		}, {
			data: "created_at"
		}, {
			data: "updated_at"
		}, {
			data: "status"
		}],
		columnDefs: [{
			targets: [0],
			orderable: !1,
			sClass: "text-center align-middle",
			render: function (data, type, row) {
				return "<input type='checkbox' style='width:13px;' id='checkItem-" + row.id + "' value='" + row.id + "'>"
			}
		}, {
			targets: [5, 8, 3],
			orderable: !1,
			visible: !1,
		}, {
			targets: [1],
			orderable: !0,
			render: function (data, type, row) {
				let html = escapeHtml(row.title.length > 50 ? row.title.substr(0, 50) + '...' : row.title)
				let tags = JSON.parse(row.category) ?? []
				let tag_ = ''
				let title = ''
				for (let index = 0; index < tags.length; index++) {
					const tagName = tags[index].split(":")[1];
					index < 1 ? tag_ += `<span class="text-xs bg-info p-1 pl-2 pr-2 rounded">${tagName}</span> ` : title += `${tagName}\n`
				}
				tag_ += tags.length > 1 ? `<span class="text-xs p-1 pl-2 bg-info rounded-circle" title="${title}"> ${tags.length - 1}+ </span>` : ''
				return `
					<div class="h6">
						${html}
					</div>
					<div>
						<span class="text-sm mr-2 text-muted">dibuat : ${moment(row.created_at).format("dddd, DD MMMM YYYY")}</span>
						<span class="float-right">${tag_}</span>
					</div>
				`
			}
		}, {
			targets: [2],
			orderable: !0,
			sClass: "text-center align-middle",
			render: function (data, type, row) {
				return `<span class="text-justify">${escapeHtml(row.author)}</span>`
			}
		}, {
			targets: [6],
			sClass: "text-center align-middle",
			render: function (data, type, row) {
				return 1 == row.status ? "<button class='btn btn-success btn-sm' id='on' data-id=" + row.id + " title='Berita Aktif'><i class='fas fa-toggle-on'></i> On</button>" : "<button class='btn btn-danger btn-sm' id='off' data-id=" + row.id + " title='Berita Tidak Aktif'><i class='fas fa-toggle-off'></i> Off</button>"
			}
		}, {
			targets: [4],
			orderable: !0,
			sClass: "text-center align-middle",
			render: function (data, type, row) {
				return row.created_at != row.updated_at ? moment(row.updated_at).startOf().fromNow() : '-'
			}
		}, {
			sClass: "text-center align-middle",
			targets: [7],
			orderable: !1,
			render: function (data, type, row) {
				return "<button class='btn btn-danger btn-sm' id='delete' data-id=" + row.id + " title='Hapus Data'><i class='fas fa-trash-alt'></i></button> \n <button class='btn btn-warning btn-sm' id='edit' data-id=" + row.id + " title='Edit Data'><i class='fas fa-pencil-alt'></i></button>"
			}
		}]
	})
}

$(document).ready((function () {
	initTable()
})), $("#listNews").delegate("#delete", "click", (function () {
	confirmSweet("Anda yakin ingin menghapus data ?").then((result) => {
		if (isConfirmed(result)) {
			let id = $(this).data("id")
			result && $.ajax({
				url: CURRENT_PATH + "delete",
				data: {
					_token: TOKEN,
					id: id
				},
				type: "POST",
				dataType: "JSON",
				beforeSend: function () {
					disableButton()
				},
				complete: function () {
					enableButton()
				},
				success: function (result) {
					"ok" == result.status ? (toastSuccess(result.message), refreshTable()) : toastError(result.message, "Gagal")
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
})), $("#listNews").delegate("#edit", "click", (function () {
	let id = $(this).data("id");
	$.ajax({
		url: API_PATH + "data/news/get/" + id,
		type: "post",
		data: {
			_token: TOKEN
		},
		dataType: "json",
		beforeSend: function () {
			disableButton()
			clearFormInput("#formBody")
			addFormInput("#formBody", [{
				type: "hidden",
				name: 'id',
			},{
				type: "hidden",
				id: "titleCheck"
			},{
				type: "text",
				name: "title",
				label: "Judul",
				required: "required",
			}, {
				type: "selectMultiple",
				name: "category",
				label: "Kategori",
				required: "required",
				dataType: "json",
				api: {
					url: `${API_PATH}data/options/category`,
					option: {
						value: "id",
						caption: "{name}"
					}
				}
			}, {
				type: "file",
				name: "cover",
				id: "cover",
				label: "Pilih Cover (Jika ingin merubah)",
			}, {
				type: "editor",
				name: "content",
				label: "Konten",
				required: "required",
			}])
			$("#formInput").validate({
				rules: {
					title: "required",
					cetegory: "required",
					content: "required"
				},
				messages: {
					cover: {
						required: "Cover harus dipilih"
					},
					title: {
						required: "Judul harus diisi"
					},
					cetegory: {
						required: "Kategori harus dipilih"
					},
				}
			})
		},
		complete: function () {
			enableButton()
		},
		success: async function (result) {
			"ok" == result.status ? ($("#modalForm").modal('show'), $("#modalTitle").html('Edit Berita'), $("#formInput").attr('action', CURRENT_PATH + "update"), await sleep(500), fillForm(result.data), $("#titleCheck").val(result.data.title)) : msgSweetError(result.message)
		},
		error: function (err) {
			errorCode(err)
		}
	})
})), $("#listNews").delegate("#reset", "click", (function (e) {
	confirmSweet("Anda yakin ingin mereset password ?").then((result) => {
		if (isConfirmed(result)) {
			let id = $(this).data("id");
			result && $.ajax({
				url: CURRENT_PATH + "reset/" + id,
				data: {
					_token: TOKEN
				},
				type: "POST",
				dataType: "JSON",
				beforeSend: function () {
					disableButton()
				},
				complete: function () {
					enableButton()
				},
				success: function (result) {
					"ok" == result.status ? toastSuccess(result.message) : toastError(result.message, "Gagal")
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
})), $("#listNews").delegate("#on", "click", (function () {
	setStatus("off", $(this).data("id"))
})), $("#listNews").delegate("#off", "click", (function () {
	setStatus("on", $(this).data("id"))
})), $("#btnAdd").on('click', function () {
	clearFormInput("#formBody")
	addFormInput("#formBody", [{
		type: "text",
		name: "title",
		label: "Judul",
		required: "required",
	}, {
		type: "selectMultiple",
		name: "category",
		label: "Kategori",
		required: "required",
		dataType: "json",
		api: {
			url: `${API_PATH}data/options/category`,
			option: {
				value: "id",
				caption: "{name}"
			}
		}
	}, {
		type: "file",
		name: "cover",
		id: "cover",
		label: "Pilih Cover",
		required: "required",
	}, {
		type: "editor",
		name: "content",
		label: "Konten",
		required: "required",
	}])
	$("#formInput").validate({
		rules: {
			cover: "required",
			title: "required",
			cetegory: "required",
			content: "required"
		},
		messages: {
			cover: {
				required: "Cover harus dipilih"
			},
			title: {
				required: "Judul harus diisi"
			},
			cetegory: {
				required: "Kategori harus dipilih"
			},
		}
	})
	$("#modalTitle").html('Tambah Berita')
	$("#formInput").attr('action', CURRENT_PATH + "store")
	$("#modalForm").modal('show')
}), $("#formInput").submit(function (e) {
	e.preventDefault()
	let messageLength = CKEDITOR.instances['content-editor'].getData().replace(/<[^>]*>/gi, '').length;
	if (!messageLength) return toastWarning("Lengkapi Form", "Peringatan")
	let formData = new FormData(this)
	formData.append("_token", TOKEN)
	if (!$(this).valid()) return toastWarning("Lengkapi Form", "Peringatan")
	$.ajax({
		url: $(this).attr('action'),
		type: "post",
		data: formData,
		processData: !1,
		contentType: !1,
		cache: !1,
		dataType: "JSON",
		beforeSend: function () {
			disableButton()
		},
		complete: function () {
			enableButton()
		},
		success: function (e) {
			validate(e.validate.input), e.validate.success && ("ok" == e.status ? (toastSuccess(e.message), refreshTable(), 1 == e.modalClose && $("#modalForm").modal("hide"), clearInput(e.validate.input)) : toastWarning(e.message));
		},
		error: function (err) {
			errorCode(err)
		}
	})
}), $(document).delegate(`input[name="title"]`, 'blur', function () {
	if ($(this).val() != $("#titleCheck").val()) { 
		$.ajax({
			url: `${CURRENT_PATH}check-title`,
			data: {
				title: $(this).val(),
				_token: TOKEN
			},
			type: "post",
			dataType: "json",
			success: function (result) {
				validate(result.input)
				// !1 == result.success ? validate(result.input) : validate(result.index)
			},
			error: function (err) {
				errorCode(err)
			}
		})
	} else {
		$(this).removeClass('is-invalid')
	}
}), refreshTableInterval = setInterval(() => {
	refreshTable()
}, REFRESH_TABLE_TIME);
