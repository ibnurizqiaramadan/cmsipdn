const BASE_URL = $('meta[name="baseUrl"]').attr('content')
const ADMIN_PATH = BASE_URL + $('meta[name="adminPath"]').attr('content')

function disableButton() {
  $(':submit').append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
  $(':submit').attr('disabled', true)
}

function enableButton() {
  $(':submit').find('span').remove()
  $(':submit').removeAttr("disabled")
}

function errorCode(event) {
  // iziToast.error({
  //   title: "Error",
  //   message: event.status + " " + event.statusText,
  //   position: 'topRight'
  // });
  console.log(event);
}

function toastInfo(msg, title = 'Info') {
  iziToast.info({
    title: title,
    message: msg.replace("'", ''),
    position: 'topRight'
  });
}

function toastSuccess(msg, title = 'Success') {
  iziToast.success({
    title: title,
    message: msg.replace("'", ''),
    position: 'topRight'
  });
}

function toastWarning(msg, title = 'Warning') {
  iziToast.warning({
    title: title,
    message: msg.replace("'", ''),
    position: 'topRight'
  });
}

function toastError(msg, title = 'Error') {
  iziToast.error({
    title: title,
    message: msg,
    position: 'topRight'
  });
}

function msgSweetError(pesan, title = 'Error', timer = 1500) {
  return swal({
    icon: 'error',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetSuccess(pesan, title = 'Sukses', timer = 1500) {
  return swal({
    icon: 'success',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetWarning(pesan, title = 'Peringatan', timer = 1500) {
  return swal({
    icon: 'warning',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetInfo(pesan, title = 'Info', timer = 1500) {
  return swal({
    icon: 'info',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function confirmSweet(pesan, title = 'Konfirmasi') {
  return swal({
    icon: 'warning',
    title: title,
    text: pesan,

    buttons: ["Tidak", "Ya"],
    dangerMode: true,
  })
}