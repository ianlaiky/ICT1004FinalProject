function popupFileExplorer(e) {
  document.querySelector('#picture').click();
}

function changePreview(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#preview').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}