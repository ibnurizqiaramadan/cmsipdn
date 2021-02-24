let CURRENT_PATH = ADMIN_PATH + "/news/";

function refreshTable() {
	table.ajax.reload(null, !1)
}
$(document).ready((function () {
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
            data: "updated_at"
        }],
		columnDefs: [{
			targets: [0],
			orderable: !1,
			sClass: "text-center",
			render: function (data, type, row) {
				return "<input type='checkbox' id='checkItem-" + row.id + "' value='" + row.id + "'>"
			}
		}, {
			targets: [3],
			orderable: !1,
			sClass: "text-center",
			render: function (data, type, row) {
				let tags = JSON.parse(row.category)
                // console.log(tags)
				let tag_ = ''
				tags.forEach(tag => {
					const tagName = tag.split(":")[1]
					tag_ += `<span class="bg-info pl-1 pr-1">${tagName}</span> `
				})
                // return tags[0]
                return tag_
			}
		}, {
			targets: [5],
			orderable: !1,
			sClass: "text-center",
			render: function (data, type, row) {
				return row.updated_at
			}
		}, {
			sClass: "text-center",
			targets: [6],
			orderable: !0,
			render: function (data, type, row) {
				return "<button class='btn btn-danger btn-sm' id='delete' data-id=" + row.id + " title='Hapus Data'><i class='fas fa-trash-alt'></i></button> \n <button class='btn btn-warning btn-sm' id='edit' data-id=" + row.id + " title='Edit Data'><i class='fas fa-pencil-alt'></i></button>"
			}
		}]
	})
})), $("#listUser").delegate("#delete", "click", (function () {
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
				success: function (result) {
					"ok" == result.status ? (enableButton(), toastSuccess(result.message), refreshTable()) : toastError(result.message, "Gagal")
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
})), $("#listUser").delegate("#edit", "click", (function () {
	let id = $(this).data("id");
	$.ajax({
		url: API_PATH + "data/category/get/" + id,
		type: "post",
		data: {_token: TOKEN},
		dataType: "json",
		beforeSend: function() {
			disableButton()
			clearFormInput("#formBody")
			addFormInput("#formBody", [{
				type: "hidden",
				name: "id"
			}, {
				type: "text",
				name: "name",
                label: "Kategori",
			}])
		}, 
		complete: function() {
			enableButton()
		},
		success: function(result) {
			"ok" == result.status ? ($("#modalForm").modal('show'),$("#modalTitle").html('Edit Pengguna'),$("#formInput").attr('action', CURRENT_PATH + "update"), FillForm(result.data)) : msgSweetError(result.message)
		},
		error: function(err) {
			errorCode(err)
		}
	})
})), $("#listUser").delegate("#reset", "click", (function (e) {
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
})), $("#listUser").delegate("#on", "click", (function () {
	setStatus("off", $(this).data("id"))
})), $("#listUser").delegate("#off", "click", (function () {
	setStatus("on", $(this).data("id"))
})), setInterval(() => {
	refreshTable()
}, 3e4), $("#btnAdd").on('click', function () {
	clearFormInput("#formBody")
	addFormInput("#formBody", [{
        type: "text",
        name: "name",
        label: "Kategori",
    }])
	$("#modalTitle").html('Tambah Pengguna')
	$("#formInput").attr('action', CURRENT_PATH + "store")
	$("#modalForm").modal('show')
}), $("#formInput").submit(function(e) {
	e.preventDefault()
	let formData = new FormData(this)
	formData.append("_token", TOKEN)
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
			validate(e.validate.input),e.validate.success&&("ok"==e.status?(toastSuccess(e.message),refreshTable(),1==e.modalClose&&$("#modalForm").modal("hide"),clearInput(e.validate.input)):toastWarning(e.message));
		},
		error: function(err) {
			errorCode(err)
		}
	})
});