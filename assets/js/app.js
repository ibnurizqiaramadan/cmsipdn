const BASE_URL = $('meta[name="baseUrl"]').attr("content"),
	ADMIN_PATH = BASE_URL + $('meta[name="adminPath"]').attr("content"),
	API_PATH = BASE_URL + $('meta[name="apiPath"]').attr("content") + "/",
	TOKEN = $('meta[name="_token"]').attr("content");
var table, table1;

function disableButton() {
	$(":submit").append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'), $(":submit").attr("disabled", !0)
}

function enableButton() {
	$(":submit").find("span").remove(), $(":submit").removeAttr("disabled")
}

function errorCode(event) {
	iziToast.error({
		title: "Error",
		message: event.status + " " + event.statusText,
		position: "topRight"
	}), console.log(event)
}

function toastInfo(msg, title = "Info") {
	iziToast.info({
		title: title,
		message: msg.replace("'", ""),
		position: "topRight"
	})
}

function toastSuccess(msg, title = "Success") {
	iziToast.success({
		title: title,
		message: msg.replace("'", ""),
		position: "topRight"
	})
}

function toastWarning(msg, title = "Warning") {
	iziToast.warning({
		title: title,
		message: msg.replace("'", ""),
		position: "topRight"
	})
}

function toastError(msg, title = "Error") {
	iziToast.error({
		title: title,
		message: msg,
		position: "topRight"
	})
}

function msgSweetError(pesan, options = {title:"Error", timer:3000}) {
	return Swal.fire({
		icon: "error",
		html: pesan,
		title: options.title,
		timer: options.timer,
		timerProgressBar: !0
	})
}

function msgSweetSuccess(pesan, options = {title:"Sukses", timer:3000}) {
	return Swal.fire({
		icon: "success",
		html: pesan,
		title: options.title,
		timer: options.timer,
		timerProgressBar: !0
	})
}

function msgSweetWarning(pesan, options = {title:"Peringatan", timer:3000}) {
	return Swal.fire({
		icon: "warning",
		html: pesan,
		title: options.title,
		timer: options.timer,
		timerProgressBar: !0
	})
}

function msgSweetInfo(pesan, options = {title:"Informasi", timer:3000}) {
	return Swal.fire({
		icon: "info",
		html: pesan,
		title: options.title,
		timer: options.timer,
		timerProgressBar: !0
	})
}

function confirmSweet(pesan, options = {title:"Konfirmasi", confirmBtn:"Ya", cancelBtn:"Tidak"}) {
	return Swal.fire({
		icon: "warning",
		title: options.title,
		html: pesan,
		showCancelButton: !0,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: options.confirmBtn,
		cancelButtonText: options.cancelBtn
	})
}

function isConfirmed(sweetResult) {
	return sweetResult.isConfirmed == true ? true : false
}

function redirect(url) {
	window.location.replace(url)
}

function validate(params) {
	Object.values(params).forEach(item => {
		1 == item.valid ? ($("[name=" + item.input + "]").addClass("is-valid1"), $("[name=" + item.input + "]").removeClass("is-invalid"), $("#validate_" + item.input).addClass("valid-feedback"), $("#validate_" + item.input).html("")) : ($("[name=" + item.input + "]").addClass("is-invalid"), $("[name=" + item.input + "]").removeClass("is-valid"), $("#validate_" + item.input).addClass("invalid-feedback"), $("#validate_" + item.input).html(item.message))
	}), selectInput(params)
}

function selectInput(params) {
	Object.values(params).some(item => ($("[name=" + item.input + "]").select(), 0 == item.valid))
}

function clearInput(params) {
	Object.values(params).forEach(item => {
		$("input[name=" + item.input + "]").val(""), $("[name=" + item.input + "]").removeClass("is-invalid"), $("[name=" + item.input + "]").removeClass("is-valid"), $("[name='" + item.input + "']").hasClass("summernote") && $("[name='" + item.input + "']").summernote("code", "")
	})
}

function FillForm(data) {
	Object.keys(data).forEach(item => {
		$("[name='" + item + "']").val(data[item]), $("[name='" + item + "']").val(data[item]).change(), $("[name='" + item + "']").hasClass("summernote") && $("[name='" + item + "']").summernote("code", data[item])
	})
}

function checkPilihan(options = {}) {
	!$("#checkedListData").length && $('table').append("<input type='hidden' id='checkedListData'>")
	const dipilih = $("#checkedListData").val().substr(0, $("#checkedListData").val().length - 1)
	const pilihanNa = dipilih.split(",")
	const dipilihNa = $("input[id^='checkItem-']");
	const jumlahInput = dipilihNa.length
	const table = $(options.table).DataTable()
	const column = table.column(0)
	$(column.footer()).html(
		"<input type='checkbox' class='checkAllItem'>"
	);
	$(column.header()).html(
		"<input type='checkbox' class='checkAllItem'>"
	);
	pilihanNa.forEach(id => {
		if (!$(`#checkItem-${id}`).is(":checked")) {
			$(`#checkItem-${id}`).prop('checked', true);
		}
	});
	let jmlCek = 0;
	for (let index = 0; index < dipilihNa.length; index++) {
		const element = dipilihNa[index];
		const btn = $(`button[data-id="${element.value}"]`)
		if ($(element).is(":checked")) {
			jmlCek++
			btn.prop('disabled', true)
		} else {
			btn.prop('disabled', false)
		}
	}
	if (jmlCek == jumlahInput) {
		$(".checkAllItem").prop('checked', true)
	} else {
		$(".checkAllItem").prop('checked', false)
	}

	if (pilihanNa.length >= 2) {
		$("#floatButton").removeClass('d-none')
	} else {
		$("#floatButton").addClass('d-none')
	}
	addFloatingButton(options)
}

function addFloatingButton(options = {}) {
	const float = $("#floatButton")
	if (float.html().trim() == '') {
		const path = options.path ?? BASE_URL
		const table = options.table
		const button = {
			"reset": `<a href="#" title="Reset" id="itemFloat" data-action="reset" data-path="${path}" data-table="${table}" class="bg-info"><i class="fas fa-sync"></i></a>`,
			"delete": `<a href="#" title="Hapus" id="itemFloat" data-action="delete" data-path="${path}" data-table="${table}" class="bg-danger"><i class="fas fa-trash-alt"></i></a>`,
			"active": `<a href="#" title="Aktifkan" id="itemFloat" data-action="active" data-path="${path}" data-table="${table}" class="bg-success"><i class="fas fa-toggle-on"></i></a>`,
			"deactive": `<a href="#" title="Non-Aktifkan" id="itemFloat" data-action="deactive" data-path="${path}" data-table="${table}" class="bg-danger"><i class="fas fa-toggle-off"></i></a>`
		}
		let buttonList = ''
		let items = options.buttons ?? []
		items.forEach(element => {
			buttonList += button[element]
		});
		float.addClass('adminActions d-none"')
		float.html(`
			<link rel="stylesheet" href="${BASE_URL}assets/css/floatingButton.css">
			<input type="checkbox" name="adminToggle" class="adminToggle" />
			<a class="adminButton" href="#!"><i class="fas fa-bars"></i></a>
			<div class="adminButtons">
				${buttonList}
			</div>
		`)
	}
}

function clearFormInput(formBody) {
	$(formBody).html('')
}

function addFormInput(formBody, inputForm = {}) {
	let html = $(formBody).html()
	let cek = 0
	Object.keys(inputForm).forEach(index => {
		const options = inputForm[index]
		if ($(`[name='${options.name}']`).length == 0) {
			cek += 1
			let selectOptionList = ''
			if (options.data) {
				if ("selectMultiple" != options.type) selectOptionList += `<option selected disabled> --- Pilih --- </option>`
				Object.keys(options.data).forEach(value => {
					const caption = options.data[value]
					selectOptionList += `<option value='${value}'>${caption}</option>`
				});
			}
			if (options.api) {
				let api = options.api
				let postData = {_token : TOKEN}
				if (api.where) postData.where = api.where
				if (api.order) postData.order = api.order
				$.ajax({
					url: api.url,
					data: postData,
					type: api.type,
					dataType: "JSON",
					success: function(result) {
						if (result.status == 'fail') return toastError(result.message)
						if ("selectMultiple" != options.type) selectOptionList += `<option selected disabled> --- Pilih --- </option>`
						Object.keys(result.data).forEach(index => {
							let caption = api.option.caption
							let value = ''
							const row = result.data[index]
							Object.keys(row).forEach(field => {
								caption = caption.replace(new RegExp(`{${field}}`, "g"), row[field])
							})
							value = row[api.option.value]
							selectOptionList += `<option value='${value}'>${caption}</option>`
							options.dataType ? $(`.select2-${options.name}`).html(selectOptionList) : $(`[name="${options.name}"]`).html(selectOptionList)
						})
					},
					error: function(err) {
						errorCode(err)
					}
				})
			}
			const inputType = {
				"hidden"   : `<input class="${options.class ?? "form-control"}" ${options.attr ?? ""} type="hidden" name="${options.name}" ${options.id ? `id="${options.id}"` : ''} ${options.value ? `value="${options.value}"` : ``} readonly>`,
				"text"     : `<input class="${options.class ?? "form-control"}" ${options.attr ?? ""} type="text" name="${options.name}" ${options.id ? `id="${options.id}"` : ''} ${options.value ? `value="${options.value}"` : ``}>`,
				"password" : `<input class="${options.class ?? "form-control"}" ${options.attr ?? ""} type="password" name="${options.name}" ${options.id ? `id="${options.id}"` : ''} ${options.value ? `value="${options.value}"` : ``}>`,
				"number"   : `<input class="${options.class ?? "form-control"}" ${options.attr ?? ""} type="number" name="${options.name}" ${options.id ? `id="${options.id}"` : ''} ${options.value ? `value="${options.value}"` : ``}>`,
				"select"   : `<select class="${options.class ?? "form-control"}" ${options.attr ?? ""} name="${options.name}" ${options.id ? `id="${options.id}"` : ''}>${selectOptionList}</select>`,
				"select2"  : `<select class="${options.class ?? "form-control select2-"}${options.name}" ${options.attr ?? ""} name="${options.name}" ${options.id ? `id="${options.id}"` : ''}>${selectOptionList}</select><script>$('.select2-${options.name}').select2({theme: 'bootstrap4'})</script>`,
				"selectMultiple"  : `<select class="${options.class ?? "form-control select2-"}${options.name}" ${options.attr ?? ""} multiple="multiple" ${options.dataType ? '' : `name="${options.name}"`} ${options.id ? `id="${options.id}"` : ''}>${selectOptionList}</select><script>$('.select2-${options.name}').select2({theme: 'bootstrap4'}), $('.select2-${options.name}').on('change',function() {$('#select2-${options.name}-result').val(JSON.stringify($(this).val()).replace('[]',''))})</script>`,
			}
			html += `
				<div class="form-group ${options.type == "hidden" ? 'd-none' : ''}">
					<label>${options.label ?? "Input"}</label>
					${inputType[options.type]}
					${options.dataType?.toLowerCase() == "json" ? `<input type="hidden" id='select2-${options.name}-result' name='${options.name}'></input>`: ''}
					<div id='validate_${options.name}'></div>
				</div>
			`
		}
	})
	if (cek != 0) {
		$(formBody).html(html)
	}
}

$(document).delegate('a[id="itemFloat"]', 'click', function (e) {
	e.preventDefault()
	var action = $(this).data('action')
	const url = $(this).data('path')
	const table = $($(this).data('table')).DataTable()
	const dataId = $("#checkedListData").val().substr(0, $("#checkedListData").val().length - 1)
	const jmlData = dataId.split(",").length
	const message = {
		"reset": `Apakah Anda yakin ingin mereset <b>${jmlData}</b> data ?`,
		"delete": `Apakan Anda yakin ingin menghapus <b>${jmlData}</b> data ?`,
		"active": `Apakan Anda yakin ingin mengaktifkan <b>${jmlData}</b> data ?`,
		"deactive": `Apakan Anda yakin ingin menonaktifkan <b>${jmlData}</b> data ?`,
	}
	confirmSweet(message[action]).then(result => {
		if (isConfirmed(result)) {
			let formData = {
				_token : TOKEN,
				dataId : dataId
			} 
			if (action == "active" || action == "deactive") formData.action = action, action = 'set'
			$.ajax({
				url: `${url}${action}-multiple`,
				type: "POST",
				dataType: "JSON",
				data: formData,
				beforeSend: function () {
					disableButton()
				},
				complete: function () {
					enableButton()
				},
				success: function (result) {
					"ok" == result.status ? (msgSweetSuccess(result.message), table.ajax.reload(null, false), $("#checkedListData").val("")) : msgSweetError(result.message)
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
})

$(document).delegate(".checkAllItem", 'click', function () {
	if ($(this).is(":checked")) {
		let pilihan = $("input[id^='checkItem-']"),
			dipilih = $("#checkedListData"),
			pilih = ''
		if (dipilih.val() != '') {
			pilih = dipilih.val()
		} else {
			pilih = ''
		}
		Object.values(pilihan).forEach(input => {
			if (typeof input === 'object' && !pilih.includes($(input).val())) {
				pilih += `${$(input).val()},`
				dipilih.val(pilih);
			}
		})
		checkPilihan()
	} else {
		let dipilihna = $("#checkedListData").val()
		let dipilihNa = $("input[id^='checkItem-']");
		for (let index = 1; index <= dipilihNa.length; index++) {
			const element = dipilihNa[index - 1];
			$(element).prop('checked', false)
			dipilihna = dipilihna.replace(new RegExp($(element).val() + ",", "g"), "")
			$("#checkedListData").val(dipilihna)
		}
		checkPilihan()
	}
})

$(document).delegate("input[id^='checkItem-']", 'click', function (e) {
	!$("#checkedListData").length && $('table').append("<textarea id='checkedListData'></textarea>")
	const id = `${$(this).val()},`
	const idCek = id.substr(0, id.length - 1)
	const btn = $(`button[data-id="${idCek}"]`)
	let dipilihna = $("#checkedListData").val()
	if ($(this).is(":checked")) {
		$("#checkedListData").val(dipilihna + id)
		btn.prop('disabled', true)
	} else {
		$("#checkedListData").val(dipilihna.replace(new RegExp(id, "g"), ""))
		btn.prop('disabled', false)
	}
	checkPilihan()
})

$(document).delegate("#btnLogout", "click", (function () {
	confirmSweet("Anda yakin ingin keluar ?").then(result => {
		result && $.ajax({
			url: ADMIN_PATH + "/login/destroy",
			type: "POST",
			data: {
				_token: TOKEN
			},
			dataType: "JSON",
			beforeSend: function () {},
			success: function (result) {
				"ok" == result.status ? redirect(ADMIN_PATH + "/login") : msgSweetError(result.message)
			}
		})
	})
}));
