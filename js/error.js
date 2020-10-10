// const skhpn= document.getElementById('skhpn');
// const nama= document.getElementById('nama');
// const jenis_identitas= document.getElementsByName('jenis_identitas');
// const no_identitas= document.getElementById('no_identitas');
// const jenis_kelamin= document.getElementsByName('jenis_kelamin');
// const tempat_lahir= document.getElementById('tempat_lahir');
// const tanggal_lahir= document.getElementById('tanggal_lahir');
// const alamat= document.getElementById('alamat');
// const pekerjaan= document.getElementById('pekerjaan');
// const no_hp= document.getElementById('no_hp');
// const keperluan= document.getElementById('keperluan');
// const foto_id= document.getElementById('foto_id');
// const captcha= document.getElementsByClassName('g-recaptcha');

// skhpn.addEventListener('submit', e => {
// 	e.preventDefault();

// 	checkInputs();
// });

// function checkInputs() {
// 	const namaValue= nama.value.trim();
// 	const jenis_identitasValue= jenis_identitas.value;
// 	const no_identitasValue= no_identitas.value;
// 	const jenis_kelaminValue= jenis_kelamin.value;
// 	const tempat_lahirValue= tempat_lahir.value;
// 	const tanggal_lahirValue= tanggal_lahir.value;
// 	const alamatValue= alamat.value;
// 	const pekerjaanValue= pekerjaan.value;
// 	const no_hpValue= no_hp.value;
// 	const keperluanValue= keperluan.value;
// 	const foto_idValue= foto_id.value;
// 	const captchaValue= captcha.value;

// 	if (namaValue === '') {
// 		setErrorFor(nama, 'Nama Harus Diisi');
// 	}else{
// 		setSuccessFor(nama);
// 	}
// }

// function setErrorFor(input, message){
// 	const formControl = document.getElementsByClassName('form-control');
// 	const small= formControl.querySelector('small');
// 	formControl.className = 'form-control error';
// 	small.innerText = message;
// }

// function setSuccessFor(input) {
// 	const formControl = document.getElementsByClassName('form-control');
// 	formControl.className = 'form-control success';
// }